<?php

namespace XoopsModules\Xcontact\Captcha;

interface CaptchaInterface
{
    public function getFormElement(): ?\XoopsFormElement;

    public function verify(): bool;

    public function getError(): string;
}
