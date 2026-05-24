<?php
/**
 * xcontact — Yardımcı fonksiyonlar
 * @package xcontact
 * @author  Eren Yumak — Aymak (aymak.net)
 */

defined('XOOPS_ROOT_PATH') || exit();

// ── Dil dosyası yükle (çift yüklemeyi önle) ──────────────────────────────────
function xcontact_load_language(string $file): void {
    static $loaded = [];
    if (isset($loaded[$file])) return;
    $loaded[$file] = true;

    $lang = 'turkish';
    if (defined('_LANGCODE') && _LANGCODE !== '') $lang = _LANGCODE;
    $path = XOOPS_ROOT_PATH . "/modules/xcontact/language/{$lang}/{$file}.php";
    if (!file_exists($path)) {
        $path = XOOPS_ROOT_PATH . "/modules/xcontact/language/turkish/{$file}.php";
    }
    if (file_exists($path)) require_once $path;
}

// ── Admin boot ───────────────────────────────────────────────────────────────
function xcontact_admin_boot(): void {
    xcontact_load_language('admin');
    xcontact_load_language('modinfo');
}

// ── Admin CSS kaydı ──────────────────────────────────────────────────────────
function xcontact_admin_register_css(): void {
    if (!isset($GLOBALS['xoTheme']) || !is_object($GLOBALS['xoTheme'])) return;
    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/xcontact/assets/css/admin.css');
}

// ── Admin şablon render (xpages pattern: doğrudan dosya path'i) ──────────────
function xcontact_admin_render(string $tpl, array $vars = []): void {
    global $xoopsTpl;

    $adminTplDir = XOOPS_ROOT_PATH . '/modules/xcontact/templates/admin/';
    $tplFile     = $adminTplDir . $tpl;

    if (!file_exists($tplFile)) {
        echo '<p style="color:red">Şablon bulunamadı: ' . htmlspecialchars($tplFile) . '</p>';
        return;
    }

    // Admin template dizinini Smarty'ye ekle
    if (method_exists($xoopsTpl, 'addTemplateDir')) {
        $xoopsTpl->addTemplateDir($adminTplDir);
    }

    // CSRF token
    $vars['xoops_token_html'] = '';
    if (isset($GLOBALS['xoopsSecurity']) && is_object($GLOBALS['xoopsSecurity'])) {
        $vars['xoops_token_html'] = $GLOBALS['xoopsSecurity']->getTokenHTML();
    }
    $vars['xoops_url']  = XOOPS_URL;
    $vars['module_url'] = XOOPS_URL . '/modules/xcontact/';

    foreach ($vars as $k => $v) $xoopsTpl->assign($k, $v);

    echo $xoopsTpl->fetch($tplFile);
}

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

// ── Admin lang değişkenlerini Smarty'e aktar ─────────────────────────────────
function xcontact_admin_assign_lang(string $page = 'all'): void {
    global $xoopsTpl;
    if (!$xoopsTpl) return;

    // Ortak (tüm sayfalarda)
    $xoopsTpl->assign('xcf_am_actions',    _AM_XCONTACT_ACTIONS);
    $xoopsTpl->assign('xcf_am_sub_new',    _AM_XCONTACT_SUB_NEW);
    $xoopsTpl->assign('xcf_am_sub_read',   _AM_XCONTACT_SUB_READ);
    $xoopsTpl->assign('xcf_am_sub_status', _AM_XCONTACT_SUB_STATUS);
    $xoopsTpl->assign('xcf_am_menu_new_form', _AM_XCONTACT_MENU_NEW_FORM);
    $xoopsTpl->assign('xcf_am_menu_subs',     _AM_XCONTACT_MENU_SUBMISSIONS);
    $xoopsTpl->assign('xcf_am_stat_status',   _AM_XCONTACT_FORM_ACTIVE);

    if ($page === 'about' || $page === 'all') {
        $xoopsTpl->assign('xcf_about_title',      _AM_XCONTACT_ABOUT_TITLE);
        $xoopsTpl->assign('xcf_about_mod_name',   _AM_XCONTACT_ABOUT_MOD_NAME);
        $xoopsTpl->assign('xcf_about_version',    _AM_XCONTACT_ABOUT_VERSION);
        $xoopsTpl->assign('xcf_about_author',     _AM_XCONTACT_ABOUT_AUTHOR);
        $xoopsTpl->assign('xcf_about_web',        _AM_XCONTACT_USAGE_TITLE);
        $xoopsTpl->assign('xcf_about_license',    _AM_XCONTACT_ABOUT_LICENSE);
        $xoopsTpl->assign('xcf_about_compat',     _AM_XCONTACT_ABOUT_COMPAT);
        $xoopsTpl->assign('xcf_about_features',   _AM_XCONTACT_ABOUT_FEATURES);
        $xoopsTpl->assign('xcf_about_usage',      _AM_XCONTACT_ABOUT_USAGE);
        $xoopsTpl->assign('xcf_about_f1',         _AM_XCONTACT_ABOUT_F1);
        $xoopsTpl->assign('xcf_about_f2',         _AM_XCONTACT_ABOUT_F2);
        $xoopsTpl->assign('xcf_about_f3',         _AM_XCONTACT_ABOUT_F3);
        $xoopsTpl->assign('xcf_about_f4',         _AM_XCONTACT_ABOUT_F4);
        $xoopsTpl->assign('xcf_about_f5',         _AM_XCONTACT_ABOUT_F5);
        $xoopsTpl->assign('xcf_about_f6',         _AM_XCONTACT_ABOUT_F6);
        $xoopsTpl->assign('xcf_about_f7',         _AM_XCONTACT_ABOUT_F7);
        $xoopsTpl->assign('xcf_about_f8',         _AM_XCONTACT_ABOUT_F8);
        $xoopsTpl->assign('xcf_about_link_usage', _AM_XCONTACT_ABOUT_LINK_USAGE);
        $xoopsTpl->assign('xcf_about_block_use',  _AM_XCONTACT_ABOUT_BLOCK_USE);
    }

    if ($page === 'forms' || $page === 'all') {
        $xoopsTpl->assign('xcf_forms_title',       _AM_XCONTACT_FORMS_TITLE);
        $xoopsTpl->assign('xcf_forms_new',         _AM_XCONTACT_FORMS_NEW);
        $xoopsTpl->assign('xcf_forms_block_info',  _AM_XCONTACT_FORMS_BLOCK_INFO);
        $xoopsTpl->assign('xcf_forms_deleted',     _AM_XCONTACT_FORMS_DELETED);
        $xoopsTpl->assign('xcf_forms_col_name',    _AM_XCONTACT_FORMS_COL_NAME);
        $xoopsTpl->assign('xcf_forms_col_slug',    _AM_XCONTACT_FORMS_COL_SLUG);
        $xoopsTpl->assign('xcf_forms_col_fields',  _AM_XCONTACT_FORMS_COL_FIELDS);
        $xoopsTpl->assign('xcf_forms_col_subs',    _AM_XCONTACT_FORMS_COL_SUBS);
        $xoopsTpl->assign('xcf_forms_col_status',  _AM_XCONTACT_FORMS_COL_STATUS);
        $xoopsTpl->assign('xcf_forms_field_count', _AM_XCONTACT_FORMS_FIELD_COUNT);
        $xoopsTpl->assign('xcf_forms_sub_count',   _AM_XCONTACT_FORMS_SUB_COUNT);
        $xoopsTpl->assign('xcf_forms_status_on',   _AM_XCONTACT_FORMS_STATUS_ON);
        $xoopsTpl->assign('xcf_forms_status_off',  _AM_XCONTACT_FORMS_STATUS_OFF);
        $xoopsTpl->assign('xcf_forms_btn_edit',    _AM_XCONTACT_FORMS_BTN_EDIT);
        $xoopsTpl->assign('xcf_forms_btn_subs',    _AM_XCONTACT_FORMS_BTN_SUBS);
        $xoopsTpl->assign('xcf_forms_btn_del',     _AM_XCONTACT_FORMS_BTN_DEL);
        $xoopsTpl->assign('xcf_forms_confirm_del', _AM_XCONTACT_FORMS_CONFIRM_DEL);
        $xoopsTpl->assign('xcf_forms_empty',       _AM_XCONTACT_FORMS_EMPTY);
        $xoopsTpl->assign('xcf_forms_create_first',_AM_XCONTACT_FORMS_CREATE_FIRST);
    }

    if ($page === 'index' || $page === 'all') {
        $xoopsTpl->assign('xcf_dash_recent_forms', _AM_XCONTACT_DASH_RECENT_FORMS);
        $xoopsTpl->assign('xcf_dash_recent_subs',  _AM_XCONTACT_DASH_RECENT_SUBS);
        $xoopsTpl->assign('xcf_dash_col_name',     _AM_XCONTACT_DASH_COL_AD);
        $xoopsTpl->assign('xcf_dash_col_slug',     _AM_XCONTACT_DASH_COL_SLUG);
        $xoopsTpl->assign('xcf_dash_col_form',     _AM_XCONTACT_DASH_COL_FORM);
        $xoopsTpl->assign('xcf_dash_col_date',     _AM_XCONTACT_DASH_COL_DATE);
        $xoopsTpl->assign('xcf_dash_no_forms',     _AM_XCONTACT_DASH_NO_FORMS);
        $xoopsTpl->assign('xcf_dash_new_form',     _AM_XCONTACT_DASH_NEW_FORM);
        $xoopsTpl->assign('xcf_dash_no_subs',      _AM_XCONTACT_DASH_NO_SUBS);
        $xoopsTpl->assign('xcf_dash_btn_forms',    _AM_XCONTACT_DASH_BTN_FORMS);
        $xoopsTpl->assign('xcf_dash_btn_view',     _AM_XCONTACT_DASH_BTN_VIEW);
        // forms status için de lazım (dashboard'da kullanılıyor)
        $xoopsTpl->assign('xcf_forms_status_on',   _AM_XCONTACT_FORMS_STATUS_ON);
        $xoopsTpl->assign('xcf_forms_status_off',  _AM_XCONTACT_FORMS_STATUS_OFF);
        $xoopsTpl->assign('xcf_forms_btn_edit',    _AM_XCONTACT_FORMS_BTN_EDIT);
    }

    if ($page === 'submissions' || $page === 'all') {
        $xoopsTpl->assign('xcf_subs_title',       _AM_XCONTACT_SUBS_TITLE);
        $xoopsTpl->assign('xcf_subs_back',        _AM_XCONTACT_SUBS_BACK);
        $xoopsTpl->assign('xcf_subs_select',      _AM_XCONTACT_SUBS_SELECT);
        $xoopsTpl->assign('xcf_subs_col_date',    _AM_XCONTACT_SUBS_COL_DATE);
        $xoopsTpl->assign('xcf_subs_col_ip',      _AM_XCONTACT_SUBS_COL_IP);
        $xoopsTpl->assign('xcf_subs_btn_view',    _AM_XCONTACT_SUBS_BTN_VIEW);
        $xoopsTpl->assign('xcf_subs_btn_del',     _AM_XCONTACT_SUBS_BTN_DEL);
        $xoopsTpl->assign('xcf_subs_confirm_del', _AM_XCONTACT_SUBS_CONFIRM_DEL);
        $xoopsTpl->assign('xcf_subs_empty',       _AM_XCONTACT_SUBS_EMPTY);
        $xoopsTpl->assign('xcf_sub_view_title',   _AM_XCONTACT_SUB_VIEW_TITLE);
        $xoopsTpl->assign('xcf_sub_view_back',    _AM_XCONTACT_SUB_VIEW_BACK);
    }
}
