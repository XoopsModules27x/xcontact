<?php

namespace XoopsModules\Xcontact\Captcha;

use XoopsModules\Xcontact\Captcha\CaptchaInterface;
class GoogleCaptcha implements CaptchaInterface
{
    protected string $error = '';

    public function getFormElement(): \XoopsFormElement
    {
        $helper = \XoopsModules\Xcontact\Helper::getInstance();
        $googleKey = $helper->getConfig('captcha_google_key');
        return new \XoopsFormLabel(
            '',
            '<div class="g-recaptcha" data-sitekey="' . $googleKey .'"></div>'
        );
    }

    public function verify(): bool
    {
        $response = $_POST['g-recaptcha-response'] ?? '';

        if ($response === '') {
            $this->error = 'Captcha missing';
            return false;
        }

        // TODO: call Google API verify endpoint
        return true;
    }

    public function getError(): string
    {
        return $this->error;
    }
}