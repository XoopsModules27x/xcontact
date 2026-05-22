<?php
/**
 * xcform — Ön yüz: form listesi
 */
require_once '../../mainfile.php';
$xoopsOption['template_main'] = 'xcform_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
xcform_load_language('main');

$forms = xcform_get_forms();
$rows  = [];
foreach ($forms as $f) {
    if (!$f['is_active']) continue;
    $rows[] = [
        'form_id' => $f['form_id'],
        'name'    => $f['name'],
        'desc'    => $f['description'],
        'url'     => XOOPS_URL . '/modules/xcform/form.php?slug=' . urlencode($f['slug']),
    ];
}

$xoopsTpl->assign('xcform_list',           $rows);
$xoopsTpl->assign('xcform_module_url',     XOOPS_URL . '/modules/xcform/');
$xoopsTpl->assign('xoops_pagetitle',       $xoopsModule->getVar('name'));
$xoopsTpl->assign('xcform_lang_no_forms',  _MD_XCFORM_NO_FORMS);
$xoopsTpl->assign('xcform_lang_fill_form', _MD_XCFORM_FILL_FORM);

require_once XOOPS_ROOT_PATH . '/footer.php';
