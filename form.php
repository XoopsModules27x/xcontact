<?php
/**
 * xcontact — Ön yüz: form görüntüleme ve gönderme
 * URL: modules/xcontact/form.php?slug=iletisim-formu
 */
require_once '../../mainfile.php';
$xoopsOption['template_main'] = 'xcontact_form.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
xcontact_load_language('main');

$slug    = isset($_GET['slug']) ? preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['slug'])) : '';
$cf_form = $slug ? xcontact_get_form_by_slug($slug) : null;

// ── Dil sabitlerini şablona aktar ────────────────────────────────────────────
$lang_vars = [
    'xcontact_lang_submit'            => _MD_XCONTACT_SUBMIT,
    'xcontact_lang_sending'           => _MD_XCONTACT_SENDING,
    'xcontact_lang_security_code'     => _MD_XCONTACT_SECURITY_CODE,
    'xcontact_lang_code_hint'         => _MD_XCONTACT_CODE_HINT,
    'xcontact_lang_success'           => _MD_XCONTACT_SUCCESS,
    'xcontact_lang_please_fix'        => _MD_XCONTACT_PLEASE_FIX,
    'xcontact_lang_select_opt'        => _MD_XCONTACT_SELECT_OPT,
    'xcontact_lang_sig_clear'         => _MD_XCONTACT_SIG_CLEAR,
    'xcontact_lang_file_hint'         => _MD_XCONTACT_FILE_HINT,
    'xcontact_lang_email_placeholder' => _MD_XCONTACT_EMAIL_PLACEHOLDER,
    'xcontact_lang_phone_placeholder' => _MD_XCONTACT_PHONE_PLACEHOLDER,
];
foreach ($lang_vars as $k => $v) $xoopsTpl->assign($k, $v);

if (!$cf_form) {
    $xoopsTpl->assign('xcontact_error',      _MD_XCONTACT_FORM_NOT_FOUND);
    $xoopsTpl->assign('xcontact_form',       null);
    $xoopsTpl->assign('xcontact_fields',     []);
    $xoopsTpl->assign('xcontact_settings',   []);
    $xoopsTpl->assign('xcontact_form_id',    0);
    $xoopsTpl->assign('xcontact_token',      '');
    $xoopsTpl->assign('xcontact_success',    false);
    $xoopsTpl->assign('xcontact_errors',     []);
    $xoopsTpl->assign('xcontact_data',       []);
    $xoopsTpl->assign('xcontact_captcha',    ['code'=>'','img'=>'']);
    $xoopsTpl->assign('xcontact_module_url', XOOPS_URL . '/modules/xcontact/');
    require_once XOOPS_ROOT_PATH . '/footer.php';
    exit;
}

$cf_fields   = json_decode($cf_form['fields']   ?? '[]', true) ?: [];
$cf_settings = json_decode($cf_form['settings'] ?? '{}', true) ?: [];
$cf_form_id  = (int)$cf_form['form_id'];
$cf_token    = md5($cf_form_id . 'xcontact_salt_aymak');
$cf_success  = false;
$cf_errors   = [];
$cf_data     = [];

// ── POST işleme ───────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (int)($_POST['cf_form_id'] ?? 0) === $cf_form_id) {
    // Token
    if (empty($_POST['cf_token']) || $_POST['cf_token'] !== $cf_token) {
        $cf_errors[] = _MD_XCONTACT_TOKEN_ERROR;
    }
    // Honeypot
    if (!empty($_POST['cf_hp'])) { $cf_success = true; }

    // Captcha
    if (!$cf_success && !empty($cf_settings['enable_captcha'])) {
        if (!xcontact_verify_captcha($_POST['cf_captcha'] ?? '')) {
            $cf_errors[] = _MD_XCONTACT_CAPTCHA_ERROR;
        }
    }

    if (!$cf_success && empty($cf_errors)) {
        foreach ($cf_fields as $field) {
            $fn    = $field['name'] ?? '';
            $ftype = $field['type'] ?? '';
            $req   = !empty($field['required']);
            if (!$fn || in_array($ftype, ['label', 'heading', 'paragraph'])) continue;

            if ($ftype === 'choice') {
                $val = isset($_POST[$fn]) ? array_map('strip_tags', (array)$_POST[$fn]) : [];
                if ($req && empty($val)) $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_REQUIRED;
            } elseif ($ftype === 'file') {
                $val = '';
                if (isset($_FILES[$fn]) && $_FILES[$fn]['error'] === UPLOAD_ERR_OK) {
                    $ext     = strtolower(pathinfo($_FILES[$fn]['name'], PATHINFO_EXTENSION));
                    $allowed = ['jpg','jpeg','png','gif','pdf','doc','docx','xls','xlsx','txt','zip'];
                    if (!in_array($ext, $allowed)) {
                        $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ': ' . _MD_XCONTACT_INVALID_EXT;
                    } elseif ($_FILES[$fn]['size'] > 5 * 1024 * 1024) {
                        $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ': ' . _MD_XCONTACT_FILE_TOO_BIG;
                    } else {
                        xcontact_ensure_upload_dir();
                        $udir = XOOPS_UPLOAD_PATH . '/xcontact/';
                        $safe = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $_FILES[$fn]['name']);
                        if (@move_uploaded_file($_FILES[$fn]['tmp_name'], $udir . $safe)) {
                            $val = XOOPS_UPLOAD_URL . '/xcontact/' . $safe;
                        }
                    }
                } elseif ($req) {
                    $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_REQUIRED;
                }
            } elseif ($ftype === 'consent') {
                $val = isset($_POST[$fn]) ? '1' : '0';
                if ($req && $val !== '1') $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_MUST_ACCEPT;
            } else {
                $val = strip_tags(trim($_POST[$fn] ?? ($field['value'] ?? '')));
                if ($req && $val === '') $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_REQUIRED;
                if ($val !== '') {
                    if ($ftype === 'email' && !filter_var($val, FILTER_VALIDATE_EMAIL)) $cf_errors[] = _MD_XCONTACT_INVALID_EMAIL;
                    if ($ftype === 'number' && !is_numeric($val)) $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_MUST_BE_NUMBER;
                }
            }
            $cf_data[$fn] = $val;
        }

        if (empty($cf_errors)) {
            $db        = $GLOBALS['xoopsDB'];
            $tbl_subs  = $db->prefix('xcontact_submissions');
            $ip        = $db->escape($_SERVER['REMOTE_ADDR'] ?? '');
            $data_json = $db->escape(json_encode($cf_data, JSON_UNESCAPED_UNICODE));
            $now       = time();
            $db->queryF("INSERT INTO {$tbl_subs} (form_id,data,ip,status,created_at) VALUES ('{$cf_form_id}','{$data_json}','{$ip}','0','{$now}')");

            // E-posta bildirimi
            if (!empty($cf_settings['notify_email'])) {
                $body  = "Form: {$cf_form['name']}\n" . _MD_XCONTACT_SUB_DATE_LABEL . ": " . date('d.m.Y H:i') . "\nIP: {$_SERVER['REMOTE_ADDR']}\n" . str_repeat('-', 40) . "\n";
                foreach ($cf_data as $k => $v) {
                    $lbl = $k;
                    foreach ($cf_fields as $fd) { if (($fd['name'] ?? '') === $k) { $lbl = $fd['label'] ?? $k; break; } }
                    $body .= $lbl . ': ' . (is_array($v) ? implode(', ', $v) : $v) . "\n";
                }
                xcontact_send_mail($cf_settings['notify_email'], $cf_settings['email_subject'] ?? _MD_XCONTACT_NEW_SUBMISSION, $body);
            }
            $cf_success = true;
        }
    }
}

// ── CAPTCHA üret (POST işleminden SONRA — session'ı ezmemek için) ────────────
$cf_captcha = ['code' => '', 'img' => ''];
if (!empty($cf_settings['enable_captcha']) && !$cf_success) {
    global $xoopsModuleConfig;
    $cap_len    = isset($xoopsModuleConfig['captcha_length']) ? (int)$xoopsModuleConfig['captcha_length'] : 5;
    $cf_captcha = xcontact_generate_captcha($cap_len);
}

// ── Şablona aktar ────────────────────────────────────────────────────────────
$xoopsTpl->assign('xcontact_form',       $cf_form);
$xoopsTpl->assign('xcontact_fields',     $cf_fields);
$xoopsTpl->assign('xcontact_settings',   $cf_settings);
$xoopsTpl->assign('xcontact_form_id',    $cf_form_id);
$xoopsTpl->assign('xcontact_token',      $cf_token);
$xoopsTpl->assign('xcontact_success',    $cf_success);
$xoopsTpl->assign('xcontact_errors',     $cf_errors);
$xoopsTpl->assign('xcontact_data',       $cf_data);   // POST'tan gelen temizlenmiş data (array)
$xoopsTpl->assign('xcontact_captcha',    $cf_captcha);
$xoopsTpl->assign('xcontact_module_url', XOOPS_URL . '/modules/xcontact/');
$xoopsTpl->assign('xoops_pagetitle',   $cf_form['name']);

require_once XOOPS_ROOT_PATH . '/footer.php';
