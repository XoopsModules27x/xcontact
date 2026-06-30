<?php
declare(strict_types=1);

namespace XoopsModules\Xcontact;

class CaptchaHandler
{
    protected array $providers = [
        'xoops'      => XoopsCaptcha::class,
        'custom'     => CustomCaptcha::class,
        'google'     => GoogleRecaptcha::class,
    ];

    public function getInstance(string $type): CaptchaInterface
    {
        $class = $this->providers[$type] ?? XoopsCaptcha::class;

        return new $class();
    }
}