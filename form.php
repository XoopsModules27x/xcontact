<?php
/**
 * xcontact — Front end: form viewing and submission
 * URL: modules/xcontact/form.php?slug=iletisim-formu
 */

use Xmf\Request;
use XoopsModules\Xcontact\{
    Captcha\CaptchaHandler
};

require_once '../../mainfile.php';
$xoopsOption['template_main'] = 'xcontact_form.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require_once __DIR__ . '/header.php';

$op   = Request::getString('op', 'list', 'POST');
$slug = Request::getString('slug');
$slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug));

$form = null;
$formObj = $formsHandler->getFormBySlug($slug);
if (empty($formObj)) {
    \redirect_header('index.php', 3, \_MD_XCONTACT_FORM_NOT_FOUND);
    exit;
}
$form = $formObj->getValuesForms();

$formFields   = $form['fields_decoded'];
$formSettings = $form['settings_decoded'];
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
    // Security Checks
    $checkPassed = true;
    if (!$GLOBALS['xoopsSecurity']->check()) {
        $formError[]  = \_MD_XCONTACT_TOKEN_ERROR;
        $checkPassed = false;
    }
    if ((bool)$formSettings['enable_captcha']) {
        $captchaHandler = new CaptchaHandler();
        $captcha = $captchaHandler->getInstance($helper->getConfig('captcha_type'));
        if (!$captcha->verify()) {
            $formError[] = _MD_XCONTACT_CAPTCHA_ERROR;
            $checkPassed = false;
        }
    }
    if ($checkPassed) {
        $result = $submissionsHandler->processSubmission($formFields, $formSettings, $form);
        $formSuccess = $result['success'];
        $formError = $result['errors'];
        $formData = $result['data'];
    }
}

// ── assign to template ────────────────────────────────────────────────────────────
$GLOBALS['xoopsTpl']->assign('xcontact_form_descr', $form['description']);
$GLOBALS['xoopsTpl']->assign('xcontact_settings',   $formSettings);
$GLOBALS['xoopsTpl']->assign('xcontact_form_id',    $formId);
$GLOBALS['xoopsTpl']->assign('xcontact_success',    $formSuccess);
$GLOBALS['xoopsTpl']->assign('xcontact_errors',     $formError);
$GLOBALS['xoopsTpl']->assign('xoops_pagetitle',     $form['name']);

// get template
$formTpl      = $formSettings['template'] ?: 'default.tpl';
$templatePath = XOOPS_ROOT_PATH . '/modules/xcontact/templates/forms/' . $formTpl;
if (!is_readable($templatePath)) {
    // Fallback to a known-good default template file
    $template = XOOPS_ROOT_PATH . '/modules/xcontact/templates/forms/default.tpl';
}

if (!$formSuccess) {
    // Form Create when first call or after error
    $GLOBALS['xoopsTpl']->assign('formTemplate', 'file:' . $templatePath);
    $formsObj = $formsHandler->get($formId);
    $action = \XCONTACT_URL . '/' . basename(__FILE__);
    $form = $formObj->getFormUI($action, $formData, $formFields, $formSettings);
    $GLOBALS['xoopsTpl']->assign('form', $form->render());
}

// load js and css
$GLOBALS['xoTheme']->addScript(\XCONTACT_URL . '/assets/js/xcontact-form.js', ['type' => 'text/javascript']);
$GLOBALS['xoTheme']->addStylesheet(\XCONTACT_URL . '/assets/css/xcontact-form.css', null);

require_once XOOPS_ROOT_PATH . '/footer.php';
