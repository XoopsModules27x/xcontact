<?php
include_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/modules/xcform/include/functions.php';
xcform_admin_boot();
xoops_cp_header();
xcform_admin_register_css();
if (class_exists('Xmf\\Module\\Admin')) \Xmf\Module\Admin::getInstance()->displayNavigation('index.php');

$db=$GLOBALS['xoopsDB'];
$tf=$db->prefix('xcform_forms'); $ts=$db->prefix('xcform_submissions');
$res=$db->query("SELECT COUNT(*) FROM {$tf}"); [$tf1]=$db->fetchRow($res);
$res=$db->query("SELECT COUNT(*) FROM {$tf} WHERE is_active=1"); [$tf2]=$db->fetchRow($res);
$res=$db->query("SELECT COUNT(*) FROM {$ts}"); [$ts1]=$db->fetchRow($res);
$res=$db->query("SELECT COUNT(*) FROM {$ts} WHERE status=0"); [$ts2]=$db->fetchRow($res);
$recent=[]; $res=$db->query("SELECT form_id,name,slug,is_active FROM {$tf} ORDER BY form_id DESC LIMIT 5");
while($row=$db->fetchArray($res)) $recent[]=$row;
$rsubs=[]; $res=$db->query("SELECT s.sub_id,s.form_id,s.status,s.created_at,f.name as form_name FROM {$ts} s LEFT JOIN {$tf} f ON f.form_id=s.form_id ORDER BY s.sub_id DESC LIMIT 5");
while($row=$db->fetchArray($res)) $rsubs[]=$row;
global $xoopsTpl;
$d=XOOPS_ROOT_PATH.'/modules/xcform/templates/admin/';
if(method_exists($xoopsTpl,'addTemplateDir')) $xoopsTpl->addTemplateDir($d);
if(isset($GLOBALS['xoopsSecurity'])) $xoopsTpl->assign('xoops_token_html',$GLOBALS['xoopsSecurity']->getTokenHTML());
$xoopsTpl->assign('xoops_url',XOOPS_URL); $xoopsTpl->assign('module_url',XOOPS_URL.'/modules/xcform/');
$xoopsTpl->assign('dashboard_title',_AM_XCFORM_DASHBOARD);
$xoopsTpl->assign('stat_cards',[
    ['value'=>$tf1,'label'=>_AM_XCFORM_STAT_FORMS,'mod'=>'purple'],
    ['value'=>$tf2,'label'=>_AM_XCFORM_STAT_ACTIVE,'mod'=>'green'],
    ['value'=>$ts1,'label'=>_AM_XCFORM_STAT_SUBS,'mod'=>'blue'],
    ['value'=>$ts2,'label'=>_AM_XCFORM_STAT_NEW_SUBS,'mod'=>'orange']
]);
$xoopsTpl->assign('recent_forms',$recent); $xoopsTpl->assign('recent_subs',$rsubs);
xcform_admin_assign_lang('index');
echo $xoopsTpl->fetch($d.'xcform_admin_index.tpl');
xoops_cp_footer();
