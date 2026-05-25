<?php
include_once '../../../include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/modules/xcontact/include/functions.php';
xcontact_admin_boot(); xoops_cp_header(); xcontact_admin_register_css();
if(class_exists('Xmf\\Module\\Admin')) \Xmf\Module\Admin::getInstance()->displayNavigation('submissions.php');
$db=$GLOBALS['xoopsDB']; $tbl_subs=$db->prefix('xcontact_submissions');
$op=$_GET['op']??'';
if($op==='delete'&&isset($_GET['id'])){
    $id=(int)$_GET['id'];
    $db->queryF("DELETE FROM {$tbl_subs} WHERE sub_id='{$id}'");
    header("Location: submissions.php?form_id=".((int)($_GET['form_id']??0))); exit;
}
if($_SERVER['REQUEST_METHOD']==='POST'&&isset($_POST['op'])&&$_POST['op']==='delete'){
    $id=(int)($_POST['id']??0);
    $fid=(int)($_POST['form_id']??0);
    $db->queryF("DELETE FROM {$tbl_subs} WHERE sub_id='{$id}'");
    header("Location: submissions.php?form_id={$fid}"); exit;
}
if($op==='view'&&isset($_GET['id'])){
    $sub=xcontact_get_submission((int)$_GET['id']);
    if(!$sub){redirect_header('submissions.php',2,_AM_XCONTACT_SUB_NOT_FOUND);exit;}
    $db->queryF("UPDATE {$tbl_subs} SET status=1 WHERE sub_id='".(int)$sub['sub_id']."'");
    $form=xcontact_get_form((int)$sub['form_id']); $fields=$form?(json_decode($form['fields'],true)?:[]):[];
    $fmap=[]; foreach($fields as $f){if(!empty($f['name']))$fmap[$f['name']]=$f['label']??$f['name'];}
    $data=json_decode($sub['data'],true)?:[];
    global $xoopsTpl;
    $d=XOOPS_ROOT_PATH.'/modules/xcontact/templates/admin/';
    if(method_exists($xoopsTpl,'addTemplateDir')) $xoopsTpl->addTemplateDir($d);
    $xoopsTpl->assign('xoops_url',XOOPS_URL); $xoopsTpl->assign('module_url',XOOPS_URL.'/modules/xcontact/');
    $xoopsTpl->assign('sub',$sub); $xoopsTpl->assign('form',$form); $xoopsTpl->assign('fmap',$fmap); $xoopsTpl->assign('data',$data);

    echo $xoopsTpl->fetch($d.'xcontact_admin_sub_view.tpl');
    xoops_cp_footer(); exit;
}
$form_id=(int)($_GET['form_id']??0); $form=$form_id?xcontact_get_form($form_id):null;
$start=max(0,(int)($_GET['start']??0)); $limit=20;
$subs=$form_id?xcontact_get_submissions($form_id,$start,$limit):[]; $total=$form_id?xcontact_count_submissions($form_id):0;
if($form_id&&$subs) $db->queryF("UPDATE {$tbl_subs} SET status=1 WHERE form_id='{$form_id}' AND status=0");
$forms=xcontact_get_forms();
global $xoopsTpl;
$d=XOOPS_ROOT_PATH.'/modules/xcontact/templates/admin/';
if(method_exists($xoopsTpl,'addTemplateDir')) $xoopsTpl->addTemplateDir($d);
$xoopsTpl->assign('xoops_url',XOOPS_URL); $xoopsTpl->assign('module_url',XOOPS_URL.'/modules/xcontact/');
$xoopsTpl->assign('subs',$subs); $xoopsTpl->assign('form',$form); $xoopsTpl->assign('forms',$forms);
$xoopsTpl->assign('form_id',$form_id); $xoopsTpl->assign('total',$total); $xoopsTpl->assign('start',$start); $xoopsTpl->assign('limit',$limit);

echo $xoopsTpl->fetch($d.'xcontact_admin_submissions.tpl');
xoops_cp_footer();
