<?php

namespace XoopsModules\Xcontact;

interface CaptchaInterface
{
    /**
     * Render the captcha HTML.
     */
    public function render(): string;

    /**
     * Validate submitted captcha.
     */
    public function verify(): bool;

    /**
     * Return last error.
     */
    public function getError(): string;
}
