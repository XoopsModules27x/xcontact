<?php

namespace XoopsModules\Xcontact\Captcha;

use Xmf\Request;
use XoopsModules\Xcontact\Captcha\CaptchaInterface;

class CustomCaptcha implements CaptchaInterface
{
    public function getFormElement(): ?\XoopsFormElement
    {
        if (is_object($GLOBALS['xoopsUser'])) {
            return null;
        }
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code  = '';
        $helper = \XoopsModules\Xcontact\Helper::getInstance();
        $cap_len = (int)$helper->getConfig('captcha_custom_length') ?: 5;
        for ($i = 0; $i < $cap_len; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }
        $_SESSION['xcontact_captcha_custom'] = $code;

        $img_data = '';
        $width = $cap_len * 25;
        if (function_exists('imagecreatetruecolor')) {
            $im  = imagecreatetruecolor($width, 44);
            $bg  = imagecolorallocate($im, 245, 245, 250);
            $ns  = imagecolorallocate($im, 190, 190, 210);
            imagefill($im, 0, 0, $bg);
            for ($i = 0; $i < 60; $i++) {
                imagesetpixel($im, random_int(0, 129), random_int(0, 43), $ns);
            }
            for ($i = 0; $i < 3; $i++) {
                imageline($im, random_int(0, 40), random_int(0, 43), random_int(80, 129), random_int(0, 43), $ns);
            }
            for ($i = 0; $i < strlen($code); $i++) {
                $cx = imagecolorallocate($im, random_int(10, 40), random_int(10, 60), random_int(100, 180));
                imagestring($im, 5, 8 + $i * 23, random_int(8, 16), $code[$i], $cx);
            }
            ob_start(); imagepng($im); $raw = ob_get_clean(); imagedestroy($im);
            $img_data = 'data:image/png;base64,' . base64_encode($raw);
        }
        $ret = '';
        $ret .= '<div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;padding-top:8px;padding-bottom:16px;">';
        if ('' !== $img_data) {
            $ret .= '<img src="' . $img_data . '" style="border:1px solid #ddd;border-radius:4px;height:44px" />';
        } else {
            $ret .= '<div style="background:#1976d2;color:#fff;padding:8px 16px;border-radius:4px;font-size:18px;font-weight:700;letter-spacing:6px;font-family:monospace">' . $code . '</div>';
        }
        $ret .= '<input type="text" name="cf_captcha" placeholder="' . _MD_XCONTACT_CODE_HINT . '" required autocomplete="off" style="width:180px;padding:10px 12px;border:1px solid #ddd;border-radius:5px;font-size:14px">';
        $ret .= '</div>';

        return new \XoopsFormLabel('', $ret);
    }

    public function verify(): bool
    {
        if (is_object($GLOBALS['xoopsUser'])) {
            return true;
        }
        $input = Request::getString('cf_captcha');
        $stored = $_SESSION['xcontact_captcha_custom'] ?? '';
        if ($stored === '') return false;
        unset($_SESSION['xcontact_captcha_custom']);
        return strtoupper(trim($input)) === strtoupper($stored);
    }

    public function getError(): string
    {
        return '';
    }
}