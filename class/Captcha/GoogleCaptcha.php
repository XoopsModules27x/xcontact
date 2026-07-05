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
        $recaptchaVerifyURL = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($googleSecurityKey)
            . '&response=' . urlencode($recaptchaResponse) . '&remoteip=' . urlencode(IPAddress::fromRequest()->asReadable());
        $usedCurl = false;
        $recaptchaCheck = [];
        if (function_exists('curl_init') && false !== ($curlHandle  = curl_init())) {
            curl_setopt($curlHandle, CURLOPT_URL, $recaptchaVerifyURL);
            curl_setopt($curlHandle, CURLOPT_FAILONERROR, true);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, 8);
            $curlReturn = curl_exec($curlHandle);
            if (false === $curlReturn) {
                trigger_error(curl_error($curlHandle));
            } else {
                $usedCurl = true;
                $recaptchaCheck = json_decode($curlReturn, true);
                if (!is_array($recaptchaCheck)) {
                    $recaptchaCheck = [];
                }
            }
            curl_close($curlHandle);
        }
        if (false === $usedCurl) {
            $context = stream_context_create([
                'http' => [
                    'timeout'       => 8,
                    'ignore_errors' => true,
                ],
            ]);

            $recaptchaResponse = @file_get_contents($recaptchaVerifyURL, false, $context);
            if (false === $recaptchaResponse) {
                $recaptchaCheck = [];
            } else {
                $recaptchaCheck = json_decode($recaptchaResponse, true);
                if (!is_array($recaptchaCheck)) {
                    $recaptchaCheck = [];
                }
            }
        }
        if (isset($recaptchaCheck['success']) && $recaptchaCheck['success'] === true) {
            $isValid = true;
        } else {
            /** @var \XoopsCaptcha $captchaInstance */
            $captchaInstance = \XoopsCaptcha::getInstance();
            /** @var array $recaptchaCheck */
            if (!empty($recaptchaCheck['error-codes']) && is_array($recaptchaCheck['error-codes'])) {
                foreach ($recaptchaCheck['error-codes'] as $msg) {
                    $captchaInstance->message[] = $msg;
                }
            }
        }

        return $isValid;
    }

    public function getError(): string
    {
        return $this->error;
    }
}