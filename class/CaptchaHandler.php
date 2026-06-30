<?php
declare(strict_types=1);

namespace XoopsModules\Xcontact;

use XoopsModules\Xcontact\Captcha;

class CaptchaHandler
{
    protected array $providers = [
        'xoops'      => Captcha\XoopsCaptcha::class,
        'custom'     => Captcha\CustomCaptcha::class,
        'google'     => Captcha\GoogleRecaptcha::class,
    ];

    public function getInstance(string $type): CaptchaInterface
    {
        $class = $this->providers[$type] ?? Captcha\XoopsCaptcha::class;

        return new $class();
    }
}