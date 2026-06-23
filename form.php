<?php
/**
 * xcontact — Front end: form viewing and submission
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
$cf_success  = false;
$cf_errors   = [];
$cf_data     = [];

// preferences for uploading files
$allowed = $helper->getConfig('upload_filetypes');
$cf_fileupload_types = _MD_XCONTACT_FORM_UPLOAD_FILETYPE . implode(', ', $allowed);

$uploadMaxSize = (int)$helper->getConfig('upload_max_size');
$cf_fileupload_size = \_MD_XCONTACT_FORM_UPLOAD_SIZE . ($uploadMaxSize / 1048576) . ' ' . \_MD_XCONTACT_FORM_UPLOAD_SIZE_MB;

$formId = Request::getInt('cf_form_id', 0, 'POST');

// ── POST processing ───────────────────────────────────────────────────────────────
if ($formId === $cf_form_id) {
    // Security Check
    if (!$GLOBALS['xoopsSecurity']->check(true, false,  'XCONTACT_TOKEN_FORM_' . $cf_form_id)) {
        $cf_errors  = \_MD_XCONTACT_TOKEN_ERROR;
    } else {
        $result     = $submissionsHandler->processSubmission($cf_fields, $cf_settings, $cf_form);
        $cf_success = $result['success'];
        $cf_errors  = $result['errors'];
        $cf_data    = $result['data'];
    }
}

// ── Generate CAPTCHA (AFTER POST request — to avoid overwriting the session) ────────────
$cf_captcha = ['code' => '', 'img' => ''];
if (!empty($cf_settings['enable_captcha']) && !$cf_success) {
    global $xoopsModuleConfig;
    $cap_len    = isset($xoopsModuleConfig['captcha_length']) ? (int)$xoopsModuleConfig['captcha_length'] : 5;
    $cf_captcha = xcontact_generate_captcha($cap_len);
}

// ── assign to template ────────────────────────────────────────────────────────────
$GLOBALS['xoopsTpl']->assign('xcontact_form',       $cf_form);
$GLOBALS['xoopsTpl']->assign('xcontact_fields',     $cf_fields);
$GLOBALS['xoopsTpl']->assign('xcontact_settings',   $cf_settings);
$GLOBALS['xoopsTpl']->assign('xcontact_form_id',    $cf_form_id);
$GLOBALS['xoopsTpl']->assign('xcontact_success',    $cf_success);
$GLOBALS['xoopsTpl']->assign('xcontact_errors',     $cf_errors);
$GLOBALS['xoopsTpl']->assign('xcontact_data',       $cf_data);   // Cleaned data (array) from POST
$GLOBALS['xoopsTpl']->assign('xcontact_captcha',    $cf_captcha);
$GLOBALS['xoopsTpl']->assign('xcontact_module_url', XOOPS_URL . '/modules/xcontact/');
$GLOBALS['xoopsTpl']->assign('xoops_pagetitle',     $cf_form['name']);
$GLOBALS['xoopsTpl']->assign('cf_fileupload_size',  $cf_fileupload_size);
$GLOBALS['xoopsTpl']->assign('cf_fileupload_types', $cf_fileupload_types);
$GLOBALS['xoopsTpl']->assign('xoops_token',$GLOBALS['xoopsSecurity']->getTokenHTML('XCONTACT_TOKEN_FORM_' . $cf_form_id));

require_once XOOPS_ROOT_PATH . '/footer.php';
