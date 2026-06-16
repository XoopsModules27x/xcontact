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

use XoopsModules\Xcontact\Constants;

require_once \dirname(__DIR__) . '/preloads/autoloader.php';
require __DIR__ . '/header.php';

// Template Index
$templateMain = 'xcontact_admin_index.tpl';

// Count all forms
$formsCount = $formsHandler->getCount();
// Count active forms
$crForms = new \CriteriaCompo();
$crForms->add(new \Criteria('is_active', Constants::FORM_IS_ACTIVE));
$formsCountActive = $formsHandler->getCount($crForms);
unset($crForms);
// Get recent forms
$crForms = new \CriteriaCompo();
$crForms->setLimit(5);
$crForms->setSort('form_id');
$crForms->setOrder('DESC');
$formsAll = $formsHandler->getAll($crForms);
foreach (\array_keys($formsAll) as $i) {
    $form = $formsAll[$i]->getValuesForms();
    $GLOBALS['xoopsTpl']->append('recent_forms', $form);
    unset($forms);
}
unset($crForms);

// Count all submissions
$subsCount = $submissionsHandler->getCount();
// Count new submissions
$crSubs = new \CriteriaCompo();
$crSubs->add(new \Criteria('status', Constants::SUBMISSION_NEW));
$subsCountNew = $submissionsHandler->getCount($crSubs);
unset($crSubs);
// Get recent submissions
$crSubs = new \CriteriaCompo();
$crSubs->setLimit(5);
$crSubs->setSort('sub_id');
$crSubs->setOrder('DESC');
$subsAll = $submissionsHandler->getAll($crSubs);
foreach (\array_keys($subsAll) as $i) {
    $sub = $subsAll[$i]->getValuesSubmissions();
    $formsObj = $formsHandler->get($sub['form_id']);
    $formName = 'Invalid from name';
    if (\is_object($formsObj)) {
        $formName = $formsObj->getVar('name');
    }
    $sub['form_name'] = $formName;
    $GLOBALS['xoopsTpl']->append('recent_subs', $sub);
    unset($forms);
}
unset($crSubs);

//if (class_exists('Xmf\\Module\\Admin')) \Xmf\Module\Admin::getInstance()->displayNavigation('index.php');
// Render Index
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('index.php'));
if ($helper->getConfig('displaySampleButton')) {
    \xoops_loadLanguage('admin/modulesadmin', 'system');
    require_once \dirname(__DIR__) . '/testdata/index.php';
    $adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_ADD_SAMPLEDATA'), '../testdata/index.php?op=load', 'add');
    $adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_SAVE_SAMPLEDATA'), '../testdata/index.php?op=save', 'add');
//    $adminObject->addItemButton(\constant('CO_' . $moduleDirNameUpper . '_EXPORT_SCHEMA'), '../testdata/index.php?op=exportschema', 'add');
    $adminObject->displayButton('left');
}

$GLOBALS['xoopsTpl']->assign('xoops_token_html',$GLOBALS['xoopsSecurity']->getTokenHTML());
$GLOBALS['xoopsTpl']->assign('dashboard_title',_AM_XCONTACT_DASHBOARD);
$GLOBALS['xoopsTpl']->assign('stat_cards',[
    ['value'=>$formsCount,'label'=>_AM_XCONTACT_STAT_FORMS,'mod'=>'purple'],
    ['value'=>$formsCountActive,'label'=>_AM_XCONTACT_STAT_ACTIVE,'mod'=>'green'],
    ['value'=>$subsCount,'label'=>_AM_XCONTACT_STAT_SUBS,'mod'=>'blue'],
    ['value'=>$subsCountNew,'label'=>_AM_XCONTACT_STAT_NEW_SUBS,'mod'=>'orange']
]);
$GLOBALS['xoopsTpl']->assign('module_url', \XCONTACT_URL . '/');

require __DIR__ . '/footer.php';
