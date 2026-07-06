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
 * @author       Eren Yumak — Aymak (aymak.net) / Goffy (wedega.com)
 */

use Xmf\Request;
use XoopsModules\Xcontact\Constants;

require __DIR__ . '/header.php';
// Get all request values
$op     = Request::getCmd('op', 'list');
$subId  = Request::getInt('sub_id');
$formId = Request::getInt('form_id');
$start  = Request::getInt('start');
$limit  = Request::getInt('limit', $helper->getConfig('adminpager'));
$GLOBALS['xoopsTpl']->assign('start', $start);
$GLOBALS['xoopsTpl']->assign('limit', $limit);

$GLOBALS['xoopsTpl']->assign('module_url', \XCONTACT_URL . '/');
$GLOBALS['xoopsTpl']->assign('xcontact_url', \XCONTACT_URL);
$GLOBALS['xoopsTpl']->assign('xcontact_upload_url', \XCONTACT_UPLOAD_URL);

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $templateMain = 'xcontact_admin_submissions.tpl';
        // get list of forms
        $formsCount = $formsHandler->getCountForms();
        if ($formsCount > 0) {
            $formsAll = $formsHandler->getAllForms($start, $limit);
            foreach (\array_keys($formsAll) as $i) {
                $forms = $formsAll[$i]->getValuesForms();
                $GLOBALS['xoopsTpl']->append('forms', $forms);
                unset($forms);
            }
        }
        // get submissions for given formId
        $crSubs = new \CriteriaCompo();
        $crSubs->add(new \Criteria('form_id', $formId));
        $submissionsCount = $submissionsHandler->getCount($crSubs);
        $GLOBALS['xoopsTpl']->assign('submissions_count', $submissionsCount);

        // Table view submissions
        $GLOBALS['xoopsTpl']->assign('form_id', $formId);
        if ($submissionsCount > 0) {
            $crSubs->setStart($start);
            $crSubs->setLimit($limit);
            $submissionsAll = $submissionsHandler->getAll($crSubs);
            foreach (\array_keys($submissionsAll) as $i) {
                $submissions = $submissionsAll[$i]->getValuesSubmissions();
                $GLOBALS['xoopsTpl']->append('submissions_list', $submissions);
                unset($submissions);
            }
            // Display Navigation
            if ($submissionsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $navQuery = 'op=list&form_id=' . (int)$formId . '&limit=' . (int)$limit;
                $pagenav = new \XoopsPageNav($submissionsCount, $limit, $start, 'start', $navQuery);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav());
            }
            $GLOBALS['xoopsTpl']->assign('xoops_token', $GLOBALS['xoopsSecurity']->getTokenHTML());
        }
        break;
    case 'view':
        $templateMain = 'xcontact_admin_sub_view.tpl';
        $submissionsObj = $submissionsHandler->get($subId);
        if (!\is_object($submissionsObj)) {
            \redirect_header('submissions.php', 3, \_AM_XCONTACT_SUB_NOT_FOUND);
        }
        // update submission to status READ
        $submissionsObj->setVar('status', Constants::SUBMISSION_READ);
        if (!$submissionsHandler->insert($submissionsObj)) {
            $GLOBALS['xoopsTpl']->assign('error', $submissionsObj->getHtmlErrors());
        }
        // get form values
        $formObj  = $formsHandler->get($submissionsObj->getVar('form_id'));
        $formName = \_AM_XCONTACT_INVALID_FORM_ID;
        $fields   = [];
        $f_name   = [];
        $f_type   = [];
        if (\is_object($formObj)) {
            $formName = $formObj->getVar('name');
            $fields   = json_decode($formObj->getVar('fields'),true);
            foreach($fields as $f){
                if (!empty($f['name'])) {
                    if (isset($f['label'])) {
                        $f_name[$f['name']] = $f['label'];
                    } else {
                        $f_name[$f['name']] = $f['name'];
                    }
                    $f_type[$f['name']] = $f['type'];
                }
            }
        }
        // get data
        $dataArr = json_decode($submissionsObj->getVar('data'),true)?:[];
        $data = [];
        foreach ($dataArr as $key => $sub) {
            $data[$key]['value'] = $sub;
            $data[$key]['name'] = $f_name[$key] ?? $key;
            $data[$key]['type'] = $f_type[$key] ?? '';
            if ('file' === ($f_type[$key] ?? '')) {
                $data[$key]['filetype'] = $submissionsHandler->getFiletypeSubmission($sub);
            } else {
                $data[$key]['filetype'] = Constants::SUB_FILETYPE_MISC;
            }
        }

        // assign all vars
        $GLOBALS['xoopsTpl']->assign('module_url',\XCONTACT_URL);
        $GLOBALS['xoopsTpl']->assign('sub',$submissionsObj->getValuesSubmissions());
        $GLOBALS['xoopsTpl']->assign('form_name', $formName);
        $GLOBALS['xoopsTpl']->assign('f_name',$f_name);
        $GLOBALS['xoopsTpl']->assign('f_type',$f_type);
        $GLOBALS['xoopsTpl']->assign('data',$data);
        $GLOBALS['xoopsTpl']->assign('filetype_image',Constants::SUB_FILETYPE_IMAGE);
        $GLOBALS['xoopsTpl']->assign('xcontact_upload_img_url', \XCONTACT_UPLOAD_IMAGE_URL . '/');
        $GLOBALS['xoopsTpl']->assign('xcontact_upload_file_url', \XCONTACT_UPLOAD_FILE_URL . '/');
        $GLOBALS['xoopsTpl']->assign('xoops_token', $GLOBALS['xoopsSecurity']->getTokenHTML());
        break;
    case 'delete':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('submissions.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $templateMain = 'xcontact_admin_submissions.tpl';
        $submissionsObj = $submissionsHandler->get($subId);
        if (!\is_object($submissionsObj)) {
            \redirect_header('submissions.php', 3, \_AM_XCONTACT_INVALID_PARAM);
        }
        $subForm_id = $submissionsObj->getVar('form_id');
        // Get submitted data
        $data = json_decode($submissionsObj->getVar('data'), true);
        if (!is_array($data)) { $data = []; }

        if ($submissionsHandler->delete($submissionsObj)) {
            // delete uploaded file
            $fileFields = [];
            $formObj = $formsHandler->get($subForm_id);
            if (is_object($formObj)) {
                $fields = json_decode($formObj->getVar('fields'), true) ?: [];
                foreach ($fields as $f) {
                    if (isset($f['type'], $f['name']) && $f['type'] === 'file') {
                        $fileFields[] = $f['name'];
                    }
                }
            }
            foreach ($data as $field => $value) {
                if (in_array($field, $fileFields, true) && is_string($value) && '' !== $value) {
                    $fileToDelete = \XCONTACT_UPLOAD_FILE_PATH . '/' . \basename($value);
                    if (is_file($fileToDelete)) {
                        unlink($fileToDelete);
                    }
                }
            }
            \redirect_header('submissions.php?form_id=' . $subForm_id, 3, \_AM_XCONTACT_SUBS_DELETED_OK);
        } else {
            $GLOBALS['xoopsTpl']->assign('error', $submissionsObj->getHtmlErrors());
        }
        break;
}
require __DIR__ . '/footer.php';
