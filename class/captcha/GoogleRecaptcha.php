<?php

namespace XoopsModules\Xcontact;

use XoopsModules\Xcontact\CaptchaInterface;

class GoogleRecaptcha implements CaptchaInterface
{
    public function render(): string
    {
        return '<div class="g-recaptcha" data-sitekey="..."></div>';
    }

    public function verify(): bool
    {
        // Call Google API
    }

    public function getError(): string
    {
        //...
    }
}