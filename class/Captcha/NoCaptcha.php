<?php
namespace XoopsModules\Xcontact\Captcha;

use XoopsModules\Xcontact\Captcha\CaptchaInterface;

class NoCaptcha implements CaptchaInterface
{
    public function getFormElement(): ?\XoopsFormElement
    {
        return null;
    }

    public function verify(): bool
    {
        return true;
    }

    public function getError(): string
    {
        return '';
    }
}