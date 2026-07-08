<?php
namespace XoopsModules\Xcontact\Captcha;

use XoopsModules\Xcontact\Captcha\CaptchaInterface;

use XoopsFormCaptcha;

\xoops_load('XoopsFormCaptcha');

class XoopsCaptcha implements CaptchaInterface
{
    protected string $error = '';

    public function getFormElement(): \XoopsFormCaptcha
    {
        return new \XoopsFormCaptcha();
    }

    public function verify(): bool
    {
        $captcha = \XoopsCaptcha::getInstance();

        if (!$captcha->verify()) {
            $this->error = $captcha->getMessage();
            return false;
        }

        return true;
    }

    public function getError(): string
    {
        return $this->error;
    }
}