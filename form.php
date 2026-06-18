<?php
/**
 * xcontact — Ön yüz: form görüntüleme ve gönderme
 * URL: modules/xcontact/form.php?slug=iletisim-formu
 */

use Xmf\Request;

require_once '../../mainfile.php';
$xoopsOption['template_main'] = 'xcontact_form.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once __DIR__ . '/header.php';

$slug   = Request::getString('slug', '', 'GET');
$slug   = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug));

$cf_form = null;
$crForms = new \CriteriaCompo();
$crForms->add(new \Criteria('slug', $slug));
if ($formsHandler->getCount($crForms) > 0) {
    $formsAll = $formsHandler->getAll($crForms);
    foreach (\array_keys($formsAll) as $i) {
        $cf_form = $formsAll[$i]->getValuesForms();
    }
} else {
    \redirect_header('index.php', 3, \_MD_XCONTACT_FORM_NOT_FOUND);
    exit;
};

$cf_fields   = json_decode($cf_form['fields']   ?? '[]', true) ?: [];
$cf_settings = json_decode($cf_form['settings'] ?? '{}', true) ?: [];
$cf_form_id  = (int)$cf_form['form_id'];
$cf_token    = md5($cf_form_id . 'xcontact_salt_aymak');
$cf_success  = false;
$cf_errors   = [];
$cf_data     = [];

// preferences for uploading files
$allowed = $helper->getConfig('upload_filetypes');
$cf_fileupload_types = _MD_XCONTACT_FORM_UPLOAD_FILETYPE . implode(', ', $allowed);

$uploadMaxSize = (int)$helper->getConfig('upload_max_size');
$cf_fileupload_size = \_MD_XCONTACT_FORM_UPLOAD_SIZE . ($uploadMaxSize / 1048576) . ' ' . \_MD_XCONTACT_FORM_UPLOAD_SIZE_MB;

$formId = Request::getInt('cf_form_id', 0, 'POST');

// ── POST işleme ───────────────────────────────────────────────────────────────
if ($formId === $cf_form_id) {
    // Token
    if (Request::getString('cf_token', '', 'POST') !== $cf_token) {
        $cf_errors[] = _MD_XCONTACT_TOKEN_ERROR;
    }
    // Honeypot
    if ('' !== Request::getString('cf_hp','', 'POST')) { $cf_success = true; }

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
                $val = Request::hasVar($fn, 'POST') ? array_map('strip_tags', Request::getArray($fn, [], 'POST')) : [];
                if ($req && empty($val)) $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_REQUIRED;
            } elseif ($ftype === 'file') {
                // TODO: replace by XoopsMediaUploader
                $val = '';
                if (isset($_FILES[$fn]) && $_FILES[$fn]['error'] === UPLOAD_ERR_OK) {
                    $ext     = strtolower(pathinfo($_FILES[$fn]['name'], PATHINFO_EXTENSION));
                    if (!in_array($ext, $allowed)) {
                        $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ': ' . _MD_XCONTACT_INVALID_EXT;
                    } elseif ($_FILES[$fn]['size'] > $uploadMaxSize) {
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
                $val = Request::getInt($fn, 0, 'POST');
                if ($req && 1 !== $val) $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_MUST_ACCEPT;
            } else {
                $raw = Request::getString($fn, '', 'POST');
                if ($raw === '' && isset($field['value'])) {
                    $raw = (string) $field['value'];
                }
                $val = strip_tags(trim($raw));
                if ($req && $val === '') $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_REQUIRED;
                if ($val !== '') {
                    if ($ftype === 'email' && !filter_var($val, FILTER_VALIDATE_EMAIL)) $cf_errors[] = _MD_XCONTACT_INVALID_EMAIL;
                    if ($ftype === 'number' && !is_numeric($val)) $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_MUST_BE_NUMBER;
                }
            }
            $cf_data[$fn] = $val;
        }

        if (empty($cf_errors)) {
            $submissionsObj = $submissionsHandler->create();
            $submissionsObj->setVar('form_id', $cf_form_id);
            $submissionsObj->setVar('data', json_encode($cf_data, JSON_UNESCAPED_UNICODE));
            $submissionsObj->setVar('ip', $_SERVER['REMOTE_ADDR']);
            $submissionsObj->setVar('status', 0);
            $submissionsObj->setVar('created_at', time());
            // Insert Data
            if ($submissionsHandler->insert($submissionsObj)) {
                // E-posta bildirimi
                if (!empty($cf_settings['notify_email'])) {
                    $body  = \_AM_XCONTACT_FORM . ':' . $cf_form['name'] . "\n" . _MD_XCONTACT_SUB_DATE_LABEL . ': ' . date('d.m.Y H:i') . "\nIP: {$_SERVER['REMOTE_ADDR']}\n" . str_repeat('-', 40) . "\n";
                    foreach ($cf_data as $k => $v) {
                        $lbl = $k;
                        foreach ($cf_fields as $fd) { if (($fd['name'] ?? '') === $k) { $lbl = $fd['label'] ?? $k; break; } }
                        $body .= $lbl . ': ' . (is_array($v) ? implode(', ', $v) : $v) . "\n";
                    }
                    xcontact_send_mail($cf_settings['notify_email'], $cf_settings['email_subject'] ?? _MD_XCONTACT_NEW_SUBMISSION, $body);
                }
                $cf_success = true;
            } else {
                // redirect after error when inserting
                \redirect_header('index.php?op=list', 5, \_MD_XCONTACT_SUBMISSION_ERROR);
                exit;
            }
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
$xoopsTpl->assign('xoops_pagetitle',     $cf_form['name']);
$xoopsTpl->assign('cf_fileupload_size',  $cf_fileupload_size);
$xoopsTpl->assign('cf_fileupload_types', $cf_fileupload_types);

require_once XOOPS_ROOT_PATH . '/footer.php';
