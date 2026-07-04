<?php
/**
 * xcontact — Front end: form viewing and submission
 * URL: modules/xcontact/form.php?slug=iletisim-formu
 */

use Xmf\Request;
use XoopsModules\Xcontact\Constants;

require_once '../../mainfile.php';
$xoopsOption['template_main'] = 'xcontact_form.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once __DIR__ . '/header.php';

$op   = Request::getString('op', 'list', 'POST');
$slug = Request::getString('slug');
$slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug));

$form = null;
$formObj = $formsHandler->getFormBySlug($slug, Constants::FORM_IS_ACTIVE);
if (false === $formObj) {
    \redirect_header('index.php', 3, \_MD_XCONTACT_FORM_NOT_FOUND);
    exit;
}
$form = $formObj->getValuesForms();

$formFields   = json_decode($form['fields']   ?? '[]', true) ?: [];
$formSettings = json_decode($form['settings'] ?? '{}', true) ?: [];
$formId       = (int)$form['form_id'];
$formSuccess  = false;
$formError    = [];
$formData     = [];

if ('list' == $op) {
    $formData = $formsHandler->initiateFormFields($formFields);
}

$cfFormId = Request::getInt('cf_form_id', 0, 'POST');

// ── POST processing ───────────────────────────────────────────────────────────────
if ('save' == $op && $formId === $cfFormId) {
    // Security Check
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $formError[]  = \_MD_XCONTACT_TOKEN_ERROR;
    } else {
        $result      = $submissionsHandler->processSubmission($formFields, $formSettings, $form);
        $formSuccess = $result['success'];
        $formError   = $result['errors'];
        $formData    = $result['data'];
    }
}

// ── Generate CAPTCHA (AFTER POST request — to avoid overwriting the session) ────────────
$cf_captcha = ['code' => '', 'img' => ''];
if (!empty($formSettings['enable_captcha']) && !$formSuccess) {
    global $xoopsModuleConfig;
    $cap_len    = isset($xoopsModuleConfig['captcha_length']) ? (int)$xoopsModuleConfig['captcha_length'] : 5;
    $cf_captcha = xcontact_generate_captcha($cap_len);
}

// ── assign to template ────────────────────────────────────────────────────────────
$GLOBALS['xoopsTpl']->assign('xcontact_form_descr', $form['description']);
$GLOBALS['xoopsTpl']->assign('xcontact_settings',   $formSettings);
$GLOBALS['xoopsTpl']->assign('xcontact_form_id',    $formId);
$GLOBALS['xoopsTpl']->assign('xcontact_success',    $formSuccess);
$GLOBALS['xoopsTpl']->assign('xcontact_errors',     $formError);
$GLOBALS['xoopsTpl']->assign('xoops_pagetitle',     $form['name']);

if (!$formSuccess) {
    // Form Create when first call or after error
    $formsObj = $formsHandler->get($formId);
    $action = \XCONTACT_URL . '/' . basename(__FILE__);
    $form = $formObj->getFormUI($action, $formData);
    $GLOBALS['xoopsTpl']->assign('form', $form->render());
}

// load js and css
$GLOBALS['xoTheme']->addScript(\XCONTACT_URL . '/assets/js/xcontact-form.js', ['type' => 'text/javascript']);
$GLOBALS['xoTheme']->addStylesheet(\XCONTACT_URL . '/assets/css/xcontact-form.css', null);

require_once XOOPS_ROOT_PATH . '/footer.php';
