<?php
include_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/modules/xcontact/include/functions.php';
xcontact_admin_boot(); xoops_cp_header(); xcontact_admin_register_css();
if(class_exists('Xmf\\Module\\Admin')) \Xmf\Module\Admin::getInstance()->displayNavigation('forms.php');
$db=$GLOBALS['xoopsDB']; $tbl=$db->prefix('xcontact_forms');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $op=trim($_POST['op']??'');
    $id=(int)($_POST['id']??0);
    if($op==='delete'&&$id){
        $db->queryF("DELETE FROM ".$db->prefix('xcontact_submissions')." WHERE form_id='{$id}'");
        $db->queryF("DELETE FROM {$tbl} WHERE form_id='{$id}'");
        header('Location: forms.php?msg=deleted'); exit;
    }
    if($op==='toggle'&&$id){
        $res=$db->query("SELECT is_active FROM {$tbl} WHERE form_id='{$id}'"); [$cur]=$db->fetchRow($res);
        $db->queryF("UPDATE {$tbl} SET is_active='".($cur?0:1)."' WHERE form_id='{$id}'");
        header('Location: forms.php'); exit;
    }
}
$forms=xcontact_get_forms(); $rows=[];
foreach($forms as $f){
    $fid=(int)$f['form_id']; $fields=json_decode($f['fields']??'[]',true)?:[];
    $rows[]=['form_id'=>$fid,'name'=>$f['name'],'slug'=>$f['slug'],'is_active'=>(int)$f['is_active'],'field_count'=>count($fields),'total_subs'=>xcontact_count_submissions($fid),'new_subs'=>xcontact_count_submissions($fid,0),'tpl_tag'=>'{xcontact slug="'.$f['slug'].'"}'];
}
global $xoopsTpl;
$d=XOOPS_ROOT_PATH.'/modules/xcontact/templates/admin/';
if(method_exists($xoopsTpl,'addTemplateDir')) $xoopsTpl->addTemplateDir($d);
if(isset($GLOBALS['xoopsSecurity'])) $xoopsTpl->assign('xoops_token_html',$GLOBALS['xoopsSecurity']->getTokenHTML());
$xoopsTpl->assign('xoops_url',XOOPS_URL); $xoopsTpl->assign('module_url',XOOPS_URL.'/modules/xcontact/');
$xoopsTpl->assign('forms',$rows); $xoopsTpl->assign('msg',$_GET['msg']??'');

echo $xoopsTpl->fetch($d.'xcontact_admin_forms.tpl');
xoops_cp_footer();
