<?php
/**
 * xcontact — Auxiliary functions
 * @package xcontact
 * @author  Eren Yumak — Aymak (aymak.net) / Goffy (wedega.com)
 */

defined('XOOPS_ROOT_PATH') || exit();

// ── handling CAPTCHA  ─────────────────────────────────────────────────────────────
function xcontact_generate_captcha(int $len = 5): array {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $code  = '';
    for ($i = 0; $i < $len; $i++) {
        $code .= $chars[random_int(0, strlen($chars) - 1)];
    }
    $_SESSION['xcontact_captcha'] = $code;

    $img_data = '';
    if (function_exists('imagecreatetruecolor')) {
        $im  = imagecreatetruecolor(130, 44);
        $bg  = imagecolorallocate($im, 245, 245, 250);
        $ns  = imagecolorallocate($im, 190, 190, 210);
        imagefill($im, 0, 0, $bg);
        for ($i = 0; $i < 60; $i++) imagesetpixel($im, random_int(0, 129), random_int(0, 43), $ns);
        for ($i = 0; $i < 3;  $i++) imageline($im, random_int(0, 40), random_int(0, 43), random_int(80, 129), random_int(0, 43), $ns);
        for ($i = 0; $i < strlen($code); $i++) {
            $cx = imagecolorallocate($im, random_int(10, 40), random_int(10, 60), random_int(100, 180));
            imagestring($im, 5, 8 + $i * 23, random_int(8, 16), $code[$i], $cx);
        }
        ob_start(); imagepng($im); $raw = ob_get_clean(); imagedestroy($im);
        $img_data = 'data:image/png;base64,' . base64_encode($raw);
    }
    return ['code' => $code, 'img' => $img_data];
}

function xcontact_verify_captcha(string $input): bool {
    $stored = $_SESSION['xcontact_captcha'] ?? '';
    if ($stored === '') return false;
    unset($_SESSION['xcontact_captcha']);
    return strtoupper(trim($input)) === strtoupper($stored);
}

// ── Send Mail ───────────────────────────────────────────────────────────────
function xcontact_send_mail(string $to, string $subject, string $body): void {
    global $xoopsConfig;
    $from    = $xoopsConfig['adminmail'] ?? ('noreply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));
    $headers = "From: {$from}\r\nReply-To: {$from}\r\nMIME-Version: 1.0\r\nContent-Type: text/plain; charset=UTF-8\r\n";
    $subj    = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    @mail($to, $subj, $body, $headers);
}
