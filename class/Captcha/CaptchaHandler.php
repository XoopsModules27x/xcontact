<?php
declare(strict_types=1);

namespace XoopsModules\Xcontact\Captcha;

use XoopsModules\Xcontact\Captcha;

class CaptchaHandler
{
    private array $map = [
        'xoops'   => XoopsCaptcha::class,
        'google'  => GoogleCaptcha::class,
        'custom'  => CustomCaptcha::class,
        'none'    => NoCaptcha::class,
    ];

    public function getInstance(string $type): CaptchaInterface
    {
        $class = $this->map[$type] ?? XoopsCaptcha::class;

        return new $class();
    }
}