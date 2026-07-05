<?php

namespace XoopsModules\Xcontact\Captcha;

use Xmf\{
    Request,
    IPAddress
};
use XoopsModules\Xcontact\{
    Captcha\CaptchaInterface,
    Helper
};

class GoogleCaptcha implements CaptchaInterface
{
    protected string $error = '';

    public function getFormElement(): \XoopsFormElement
    {
        $helper = Helper::getInstance();
        $googleWebsiteKey = $helper->getConfig('captcha_google_websitekey');
        $captcha = '<script src="https://www.google.com/recaptcha/api.js"></script>';
        $captcha .= '<div class="form-group"><div class="g-recaptcha" data-sitekey="'
            . $googleWebsiteKey . '"></div></div>';

        return new \XoopsFormLabel('', $captcha);

    }

    public function verify(): bool
    {
        $isValid = false;
        $recaptchaResponse = Request::getString('g-recaptcha-response', '');
        if ($recaptchaResponse === '') {
            $this->error = 'Captcha missing';
            return false;
        }
        $helper = Helper::getInstance();
        $googleSecurityKey = $helper->getConfig('captcha_google_securitykey');
        $recaptchaVerifyURL = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $googleSecurityKey
            . '&response=' .  $recaptchaResponse . '&remoteip=' . IPAddress::fromRequest()->asReadable();
        $usedCurl = false;
        if (function_exists('curl_init') && false !== ($curlHandle  = curl_init())) {
            curl_setopt($curlHandle, CURLOPT_URL, $recaptchaVerifyURL);
            curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 5);
            $curlReturn = curl_exec($curlHandle);
            if (false === $curlReturn) {
                trigger_error(curl_error($curlHandle));
            } else {
                $usedCurl = true;
                $recaptchaCheck = json_decode($curlReturn, true);
            }
            curl_close($curlHandle);
        }
        if (false === $usedCurl) {
            $recaptchaCheck = file_get_contents($recaptchaVerifyURL);
            $recaptchaCheck = json_decode($recaptchaCheck, true);
        }
        if (isset($recaptchaCheck['success']) && $recaptchaCheck['success'] === true) {
            $isValid = true;
        } else {
            /** @var \XoopsCaptcha $captchaInstance */
            $captchaInstance = \XoopsCaptcha::getInstance();
            /** @var array $recaptchaCheck */
            foreach ($recaptchaCheck['error-codes'] as $msg) {
                $captchaInstance->message[] = $msg;
            }
        }

        return $isValid;
    }

    public function getError(): string
    {
        return $this->error;
    }
}