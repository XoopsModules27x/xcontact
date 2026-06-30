<?php
namespace XoopsModules\Xcontact\Captcha;

use XoopsModules\Xcontact\CaptchaInterface;

class XoopsCaptcha implements CaptchaInterface
{
    protected string $error = '';

    public function render(): string
    {

        xoops_load('XoopsCaptcha');
        $captcha = XoopsCaptcha::getInstance();

        return $captcha->render();
    }

    public function verify(): bool
    {
        xoops_load('XoopsCaptcha');

        $xoopsCaptcha = XoopsCaptcha::getInstance();
        if (!$xoopsCaptcha->verify()) {
            $this->error = $xoopsCaptcha->getMessage();
            return false;
        }

        return true;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
