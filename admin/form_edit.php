<?php

require __DIR__ . '/header.php';

require_once XOOPS_ROOT_PATH . '/modules/xcontact/include/functions.php';

if(class_exists('Xmf\\Module\\Admin')) \Xmf\Module\Admin::getInstance()->displayNavigation('form_edit.php');
$db=$GLOBALS['xoopsDB']; $tbl=$db->prefix('xcontact_forms');
$form_id=isset($_REQUEST['id'])?(int)$_REQUEST['id']:0; $is_edit=$form_id>0;
$form=['form_id'=>0,'name'=>'','slug'=>'','description'=>'','fields'=>'[]','settings'=>'{}','is_active'=>1];
if($is_edit){$found=xcontact_get_form($form_id);if(!$found){redirect_header('forms.php',2,_AM_XCONTACT_FORM_NOT_FOUND);exit;}$form=$found;}
if(isset($_POST['op'])&&$_POST['op']==='save'){
    $name=$db->escape(trim($_POST['form_name']??''));
    $slug=$db->escape(preg_replace('/[^a-z0-9\-]/','',strtolower(trim($_POST['form_slug']??''))));
    $desc=$db->escape(trim($_POST['form_desc']??''));
    $is_active=isset($_POST['is_active'])?1:0;
    $fd=json_decode($_POST['fields_json']??'[]',true); if(!is_array($fd))$fd=[];
    $fj=$db->escape(json_encode($fd,JSON_UNESCAPED_UNICODE));
    $st=$db->escape(json_encode(['success_msg'=>trim($_POST['success_msg']??'Formunuz başarıyla gönderildi. Teşekkürler!'),'notify_email'=>trim($_POST['notify_email']??''),'email_subject'=>trim($_POST['email_subject']??'Yeni Form Gönderisi'),'enable_captcha'=>isset($_POST['enable_captcha'])?1:0],JSON_UNESCAPED_UNICODE));
    $now=time();
    if($is_edit) $db->queryF("UPDATE {$tbl} SET name='{$name}',slug='{$slug}',description='{$desc}',fields='{$fj}',settings='{$st}',is_active='{$is_active}' WHERE form_id='{$form_id}'");
    else $db->queryF("INSERT INTO {$tbl}(name,slug,description,fields,settings,is_active,created_at)VALUES('{$name}','{$slug}','{$desc}','{$fj}','{$st}','{$is_active}','{$now}')");
    redirect_header('forms.php',2,_AM_XCONTACT_FORM_SAVED); exit;
}
$settings=json_decode($form['settings']??'{}',true)?:[];
global $xoopsTpl;
$d=XOOPS_ROOT_PATH.'/modules/xcontact/templates/admin/';
if(method_exists($xoopsTpl,'addTemplateDir')) $xoopsTpl->addTemplateDir($d);
if(isset($GLOBALS['xoopsSecurity'])) $xoopsTpl->assign('xoops_token_html',$GLOBALS['xoopsSecurity']->getTokenHTML());
$xoopsTpl->assign('xoops_url',XOOPS_URL); $xoopsTpl->assign('module_url',XOOPS_URL.'/modules/xcontact/');
$xoopsTpl->assign('form',$form); $xoopsTpl->assign('settings',$settings); $xoopsTpl->assign('is_edit',$is_edit);

echo $xoopsTpl->fetch($d.'xcontact_admin_form_edit.tpl');
xoops_cp_footer();