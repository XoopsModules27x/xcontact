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
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_NEW, 'form_edit.php?op=new');
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
        }
        if (!\is_object($formsObj)) {
            \redirect_header('forms.php', 3, \_AM_XCONTACT_INVALID_PARAM);
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
        $form = $formsObj->getFormForms();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'new':
        // TODO: implement form_edit here
        /*$templateMain = 'xcontact_admin_forms.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('forms.php'));
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_LIST, 'forms.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $formsObj = $formsHandler->create();
        $form = $formsObj->getFormForms();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());*/
        break;
    case 'clone':
        //TODO: implement button and testing
        $templateMain = 'xcontact_admin_forms.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('forms.php'));
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_LIST, 'forms.php', 'list');
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_NEW, 'forms.php?op=new');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton('left'));
        // Request source
        $formIdSource = Request::getInt('form_id_source');
        // Check params
        if (0 === $formIdSource) {
            \redirect_header('forms.php?op=list', 3, \_AM_XCONTACT_INVALID_PARAM);
        }
        // Get Form
        $formsObjSource = $formsHandler->get($formIdSource);
        if (!\is_object($formsObjSource)) {
            \redirect_header('forms.php', 3, \_AM_XCONTACT_INVALID_PARAM);
        }
        $formsObj = $formsObjSource->xoopsClone();
        $formsObj->setNew();
        $formsObj->setVar('form_id', 0);
        $form = $formsObj->getFormForms();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // TODO: implement form_edit here
        /*$templateMain = 'xcontact_admin_forms.tpl';
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('forms.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($formId > 0) {
            $formsObj = $formsHandler->get($formId);
        } else {
            $formsObj = $formsHandler->create();
        }
        if (!\is_object($formsObj)) {
            \redirect_header('forms.php', 3, \_AM_XCONTACT_INVALID_PARAM);
        }
        // Set Vars
        $formsObj->setVar('name', Request::getString('form_name'));
        $formsObj->setVar('slug', Request::getString('form_slug'));
        $formsObj->setVar('description', Request::getString('form_description'));
        $formsObj->setVar('fields', Request::getString('form_fields'));
        $formsObj->setVar('settings', Request::getString('form_settings'));
        $formsObj->setVar('is_active', Request::getInt('form_is_active'));
        $formsCreated_atObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('form_created_at'));
        if (false === $formsCreated_atObj) {
            // Get Form
            $GLOBALS['xoopsTpl']->assign('error', \_AM_XCONTACT_INVALID_DATE);
            $form = $formsObj->getFormForms();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
            break;
        }
        $formsObj->setVar('created_at', $formsCreated_atObj->getTimestamp());
        $formsObj->setVar('submitter', Request::getInt('form_submitter'));
        // Insert Data
        if ($formsHandler->insert($formsObj)) {
            $savedFormId = $formId > 0 ? $formId : $formsObj->getNewInsertedIdForms();
                \redirect_header('forms.php?op=list&start=' . $start . '&limit=' . $limit, 2, \_AM_XCONTACT_FORM_OK);
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $formsObj->getHtmlErrors());
        $form = $formsObj->getFormForms();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());*/
        break;
    case 'edit':
        $templateMain = 'xcontact_admin_forms.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('forms.php'));
        $adminObject->addItemButton(\_AM_XCONTACT_FORMS_NEW, 'forms.php?op=new');
        $adminObject->addItemButton(\_AM_XCONTACT_LIST_FORMS, 'forms.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->renderButton('left'));
        // Get Form
        $formsObj = $formsHandler->get($formId);
        if (!\is_object($formsObj)) {
            \redirect_header('forms.php', 3, \_AM_XCONTACT_INVALID_PARAM);
        }
        $formsObj->start = $start;
        $formsObj->limit = $limit;
        $form = $formsObj->getFormForms();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'xcontact_admin_forms.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->renderNavigation('forms.php'));
        $formsObj = $formsHandler->get($formId);
        if (!\is_object($formsObj)) {
            \redirect_header('forms.php', 3, \_AM_XCONTACT_INVALID_PARAM);
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
