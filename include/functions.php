<?php
/**
 * xcontact — Yardımcı fonksiyonlar
 * @package xcontact
 * @author  Eren Yumak — Aymak (aymak.net)
 */

defined('XOOPS_ROOT_PATH') || exit();

// ── DB: tüm formlar ──────────────────────────────────────────────────────────
function xcontact_get_forms(): array {
    $db  = $GLOBALS['xoopsDB'];
    $tbl = $db->prefix('xcontact_forms');
    $res = $db->query("SELECT * FROM {$tbl} ORDER BY form_id DESC");
    $rows = [];
    while ($row = $db->fetchArray($res)) $rows[] = $row;
    return $rows;
}

function xcontact_get_form(int $id): ?array {
    $db  = $GLOBALS['xoopsDB'];
    $tbl = $db->prefix('xcontact_forms');
    $res = $db->query("SELECT * FROM {$tbl} WHERE form_id='" . (int)$id . "'");
    return $res ? ($db->fetchArray($res) ?: null) : null;
}

function xcontact_get_form_by_slug(string $slug): ?array {
    $db   = $GLOBALS['xoopsDB'];
    $tbl  = $db->prefix('xcontact_forms');
    $safe = $db->escape(preg_replace('/[^a-z0-9\-]/', '', strtolower($slug)));
    $res  = $db->query("SELECT * FROM {$tbl} WHERE slug='{$safe}' AND is_active='1'");
    return $res ? ($db->fetchArray($res) ?: null) : null;
}

function xcontact_count_submissions(int $form_id, ?int $status = null): int {
    $db  = $GLOBALS['xoopsDB'];
    $tbl = $db->prefix('xcontact_submissions');
    $w   = "WHERE form_id='" . (int)$form_id . "'";
    if ($status !== null) $w .= " AND status='" . (int)$status . "'";
    $res = $db->query("SELECT COUNT(*) FROM {$tbl} {$w}");
    [$cnt] = $db->fetchRow($res);
    return (int)$cnt;
}

function xcontact_get_submissions(int $form_id, int $start = 0, int $limit = 20): array {
    $db  = $GLOBALS['xoopsDB'];
    $tbl = $db->prefix('xcontact_submissions');
    $res = $db->query("SELECT * FROM {$tbl} WHERE form_id='" . (int)$form_id . "' ORDER BY sub_id DESC LIMIT " . (int)$limit . " OFFSET " . (int)$start);
    $rows = [];
    while ($row = $db->fetchArray($res)) $rows[] = $row;
    return $rows;
}

function xcontact_get_submission(int $id): ?array {
    $db  = $GLOBALS['xoopsDB'];
    $tbl = $db->prefix('xcontact_submissions');
    $res = $db->query("SELECT * FROM {$tbl} WHERE sub_id='" . (int)$id . "'");
    return $res ? ($db->fetchArray($res) ?: null) : null;
}

// ── Upload klasörü ──────────────────────────────────────────────────────────
function xcontact_ensure_upload_dir(): bool {
    $dir = XOOPS_UPLOAD_PATH . '/xcontact';
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) return false;
    $htaccess = $dir . '/.htaccess';
    if (!file_exists($htaccess)) {
        file_put_contents($htaccess, "Options -Indexes\n<Files *.php>\n  deny from all\n</Files>\n");
    }
    return true;
}

// ── CAPTCHA üret ─────────────────────────────────────────────────────────────
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

// ── Mail gönder ───────────────────────────────────────────────────────────────
function xcontact_send_mail(string $to, string $subject, string $body): void {
    global $xoopsConfig;
    $from    = $xoopsConfig['adminmail'] ?? ('noreply@' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));
    $headers = "From: {$from}\r\nReply-To: {$from}\r\nMIME-Version: 1.0\r\nContent-Type: text/plain; charset=UTF-8\r\n";
    $subj    = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    @mail($to, $subj, $body, $headers);
}
