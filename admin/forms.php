<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xContact module for xoops
 *
 * @copyright    2026 XOOPS Project (https://xoops.org)
 * @license      GPL 2.0 or later
 * @package      xcontact
 * @author       TDM XOOPS - Email:info@email.com - Website:http://xoops.org
 */

use Xmf\Request;
use XoopsModules\Xcontact;
use XoopsModules\Xcontact\Constants;
use XoopsModules\Xcontact\Common;

require __DIR__ . '/header.php';
// Get all request values
$op     = Request::getCmd('op', 'list');
$formId = Request::getInt('form_id');
$start  = Request::getInt('start');
$limit  = Request::getInt('limit', $helper->getConfig('adminpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

$msg = Request::getString('msg');
$GLOBALS['xoopsTpl']->assign('msg',$msg);

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'xcontact_admin_forms.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('forms.php'));
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_NEW, 'forms.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton('left'));
        $formsCount = $formsHandler->getCountForms();
        $formsAll = $formsHandler->getAllForms($start, $limit);
        $GLOBALS['xoopsTpl']->assign('forms_count', $formsCount);
        $GLOBALS['xoopsTpl']->assign('xcontact_url', \XCONTACT_URL);
        $GLOBALS['xoopsTpl']->assign('xcontact_upload_url', \XCONTACT_UPLOAD_URL);
        // Table view forms
        if ($formsCount > 0) {
            foreach (\array_keys($formsAll) as $i) {
                $forms = $formsAll[$i]->getValuesForms();
                $GLOBALS['xoopsTpl']->append('forms_list', $forms);
                unset($forms);
            }
            // Display Navigation
            if ($formsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($formsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
            $GLOBALS['xoopsTpl']->assign('xoops_token', $GLOBALS['xoopsSecurity']->getTokenHTML());
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_XCONTACT_THEREARENO_FORMS);
        }
        break;
    case 'toggle':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('forms.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $formsObj = null;
        if ($formId > 0) {
            $formsObj = $formsHandler->get($formId);
        } else {
            \redirect_header('forms.php', 3, \_MD_XCONTACT_INVALID_PARAM);
        }
        if (!\is_object($formsObj)) {
            \redirect_header('forms.php', 3, \_MD_XCONTACT_INVALID_PARAM);
        }
        // Set Vars
        $isActive = 0 === (int)$formsObj->getVar('is_active') ? 1 : 0;
        $formsObj->setVar('is_active', $isActive);
        // Insert Data
        if ($formsHandler->insert($formsObj)) {
            \redirect_header('forms.php?op=list&start=' . $start . '&limit=' . $limit, 2, \_AM_XCONTACT_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $formsObj->getHtmlErrors());
        break;
    case 'clone':
        $templateMain = 'xcontact_admin_form_edit.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('forms.php'));
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_LIST, 'forms.php', 'list');
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_NEW, 'forms.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton('left'));
        // Request source
        $formIdSource = Request::getInt('form_id_source');
        // Check params
        if (0 === $formIdSource) {
            \redirect_header('forms.php?op=list', 3, \_MD_XCONTACT_INVALID_PARAM);
        }
        // Get Form
        $formsObjSource = $formsHandler->get($formIdSource);
        if (!\is_object($formsObjSource)) {
            \redirect_header('forms.php', 3, \_MD_XCONTACT_INVALID_PARAM);
        }
        $formsObj = $formsObjSource->xoopsClone();
        $formsObj->setNew();
        $formsObj->setVar('form_id', 0);
        $form = $formsObj->getValues();
        $GLOBALS['xoopsTpl']->assign('form_header', \_AM_XCONTACT_FORMS_CLONE);
        $GLOBALS['xoopsTpl']->assign('form', $form);
        $settings = \json_decode((string)($form['settings'] ?? '{}'), true) ?: [];
        $GLOBALS['xoopsTpl']->assign('settings', $settings);
        $GLOBALS['xoopsTpl']->assign('module_url', \XCONTACT_URL . '/');
        $GLOBALS['xoopsTpl']->assign('xoops_token_html', $GLOBALS['xoopsSecurity']->getTokenHTML());
        break;
    case 'new':
        $templateMain = 'xcontact_admin_form_edit.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('forms.php'));
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_LIST, 'forms.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton('left'));
        //set default values
        $form=[
            'form_id'=>0,
            'name'=>'',
            'slug'=>'',
            'description'=>'',
            'fields'=>'[]',
            'settings'=>'{}',
            'is_active'=>Constants::FORM_IS_ACTIVE
        ];
        $GLOBALS['xoopsTpl']->assign('form_header', \_AM_XCONTACT_FORMS_NEW);
        $GLOBALS['xoopsTpl']->assign('form', $form);
        $GLOBALS['xoopsTpl']->assign('start', $start);
        $GLOBALS['xoopsTpl']->assign('limit', $limit);
        $GLOBALS['xoopsTpl']->assign('module_url', \XCONTACT_URL . '/');
        $GLOBALS['xoopsTpl']->assign('xoops_token_html',$GLOBALS['xoopsSecurity']->getTokenHTML());
        break;
    case 'edit':
        $templateMain = 'xcontact_admin_form_edit.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('forms.php'));
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_NEW, 'forms.php?op=new');
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_LIST, 'forms.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton('left'));
        // Get Form
        if ($formId > 0) {
            $formsObj = $formsHandler->get($formId);
        } else {
            \redirect_header('forms.php', 3, \_MD_XCONTACT_INVALID_PARAM);
        }
        if (!\is_object($formsObj)) {
            \redirect_header('forms.php', 3, \_MD_XCONTACT_INVALID_PARAM);
        }
        $form = $formsObj->getValues();
        $GLOBALS['xoopsTpl']->assign('form_header', \_AM_XCONTACT_FORMS_EDIT);
        $GLOBALS['xoopsTpl']->assign('form', $form);
        $GLOBALS['xoopsTpl']->assign('start', $start);
        $GLOBALS['xoopsTpl']->assign('limit', $limit);
        $settings=json_decode($form['settings']??'{}',true)?:[];
        $GLOBALS['xoopsTpl']->assign('settings',$settings);
        $GLOBALS['xoopsTpl']->assign('module_url', \XCONTACT_URL . '/');
        $GLOBALS['xoopsTpl']->assign('xoops_token_html',$GLOBALS['xoopsSecurity']->getTokenHTML());
        break;

    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('forms.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        //ensure that data are sent by POST
        if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
            if ($formId > 0) {
                $formsObj = $formsHandler->get($formId);
            } else {
                $formsObj = $formsHandler->create();
            }
        } else {
            \redirect_header('forms.php', 3, \_MD_XCONTACT_INVALID_PARAM);
        }
        if (!\is_object($formsObj)) {
            \redirect_header('forms.php', 3, \_MD_XCONTACT_INVALID_PARAM);
        }
        // Set Vars
        $formName = trim(Request::getString('form_name'));
        $formsObj->setVar('name', $formName);

        $slug = preg_replace('/[^a-z0-9\-]/','',strtolower(trim(Request::getString('form_slug'))));
        if ('' === $slug) {
            $slug = preg_replace('/[^a-z0-9\-]/','',strtolower($formName)) . '-' . time();
        }
        $formsObj->setVar('slug', $slug);
        $formsObj->setVar('description', trim(Request::getString('form_desc')));
        $fieldsJson = Request::getText('fields_json', '[]');
        $fieldsJson = json_decode($fieldsJson,true);
        if(!is_array($fieldsJson)) {
            $fieldsJson=[];
        }
        $formsObj->setVar('fields', json_encode($fieldsJson,JSON_UNESCAPED_UNICODE));
        $enableCaptcha = Constants::CAPTCHA_DISABLED;
        if (Request::hasVar('enable_captcha', 'POST')) {
            $enableCaptcha = Constants::CAPTCHA_ENABLED;
        }
        $formSettings=json_encode([
            'success_msg'=>trim(Request::getString('success_msg', \_AM_XCONTACT_SET_DEFAULT_SUCCESS)),
            'notify_email'=>trim(Request::getString('notify_email')),
            'email_subject'=>trim(Request::getString('email_subject',\_AM_XCONTACT_SET_DEFAULT_SUBJECT)),
            'enable_captcha'=>$enableCaptcha
        ],JSON_UNESCAPED_UNICODE);
        $formsObj->setVar('settings', $formSettings);
        $formsObj->setVar('is_active', Request::getInt('is_active'));
        $formsObj->setVar('created_at', time());
        $uidCurrent = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
        $formsObj->setVar('submitter', $uidCurrent);
        // Insert Data
        if ($formsHandler->insert($formsObj)) {
            \redirect_header('forms.php?op=list&start=' . $start . '&limit=' . $limit, 2, \_AM_XCONTACT_FORM_OK);
        }
        $templateMain = 'xcontact_admin_form_edit.tpl';
        // Get errors
        $GLOBALS['xoopsTpl']->assign('error', $formsObj->getHtmlErrors());
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('forms.php'));
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_LIST, 'forms.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton('left'));
        $GLOBALS['xoopsTpl']->assign('form_header', $formId > 0 ? \_AM_XCONTACT_FORMS_EDIT : \_AM_XCONTACT_FORMS_NEW);
        $GLOBALS['xoopsTpl']->assign('form', $formsObj->getValues());
        $GLOBALS['xoopsTpl']->assign('settings', \json_decode((string)$formsObj->getVar('settings'), true) ?: []);
        $GLOBALS['xoopsTpl']->assign('module_url', \XCONTACT_URL . '/');
        $GLOBALS['xoopsTpl']->assign('xoops_token_html', $GLOBALS['xoopsSecurity']->getTokenHTML());
        break;
    case 'delete':
        $templateMain = 'xcontact_admin_forms.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('forms.php'));
        $formsObj = $formsHandler->get($formId);
        if (!\is_object($formsObj)) {
            \redirect_header('forms.php', 3, \_MD_XCONTACT_INVALID_PARAM);
        }
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('forms.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($formsHandler->delete($formsObj)) {
            $submissionsHandler = $helper->getHandler('Submissions');
            $critSubmissions = new \Criteria('form_id', $formId);
            $submissionsHandler->deleteAll($critSubmissions);
            \redirect_header('forms.php', 3, \_AM_XCONTACT_FORM_DELETED);
        } else {
            $GLOBALS['xoopsTpl']->assign('error', $formsObj->getHtmlErrors());
        }
        break;
}
require __DIR__ . '/footer.php';
