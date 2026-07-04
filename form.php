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

$op     = Request::getString('op', 'list', 'POST');
$slug   = Request::getString('slug');
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

if ('list' == $op) {
    // initialize all fields with default value
    foreach ($cf_fields as $f) {
        if (in_array($f['type'], ['radio', 'choice', 'dropdown', 'image_choice'], true)) {
            $cf_data[$f['name']] = [];
        } else {
            $cf_data[$f['name']] = '';
        }
    }
}

$formId = Request::getInt('cf_form_id', 0, 'POST');

// ── POST processing ───────────────────────────────────────────────────────────────
if ('save' == $op && $formId === $cf_form_id) {
    // Security Check
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $cf_errors[]  = \_MD_XCONTACT_TOKEN_ERROR;
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
$GLOBALS['xoopsTpl']->assign('xcontact_form_descr', $cf_form['description']);
$GLOBALS['xoopsTpl']->assign('xcontact_settings',   $cf_settings);
$GLOBALS['xoopsTpl']->assign('xcontact_form_id',    $cf_form_id);
$GLOBALS['xoopsTpl']->assign('xcontact_success',    $cf_success);
$GLOBALS['xoopsTpl']->assign('xcontact_errors',     $cf_errors);
$GLOBALS['xoopsTpl']->assign('xoops_pagetitle',     $cf_form['name']);

if (!$cf_success) {
    // Form Create
    $formsObj = $formsHandler->get($cf_form_id);
    $form = $formsObj->getFormUI($cf_data);
    $GLOBALS['xoopsTpl']->assign('form', $form->render());
}

require_once XOOPS_ROOT_PATH . '/footer.php';
