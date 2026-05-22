<?php
include_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/modules/xcform/include/functions.php';
xcform_admin_boot(); xoops_cp_header(); xcform_admin_register_css();
if(class_exists('Xmf\\Module\\Admin')) \Xmf\Module\Admin::getInstance()->displayNavigation('about.php');
global $xoopsTpl;
$d=XOOPS_ROOT_PATH.'/modules/xcform/templates/admin/';
if(method_exists($xoopsTpl,'addTemplateDir')) $xoopsTpl->addTemplateDir($d);
$xoopsTpl->assign('xoops_url',XOOPS_URL); $xoopsTpl->assign('module_url',XOOPS_URL.'/modules/xcform/');
xcform_admin_assign_lang('about');
echo $xoopsTpl->fetch($d.'xcform_admin_about.tpl');
xoops_cp_footer();
