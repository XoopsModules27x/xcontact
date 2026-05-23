<?php
/**
 * xcontact — Ön yüz: form listesi
 */
require_once '../../mainfile.php';
$xoopsOption['template_main'] = 'xcontact_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
xcontact_load_language('main');

$forms = xcontact_get_forms();
$rows  = [];
foreach ($forms as $f) {
    if (!$f['is_active']) continue;
    $rows[] = [
        'form_id' => $f['form_id'],
        'name'    => $f['name'],
        'desc'    => $f['description'],
        'url'     => XOOPS_URL . '/modules/xcontact/form.php?slug=' . urlencode($f['slug']),
    ];
}

$xoopsTpl->assign('xcontact_list',           $rows);
$xoopsTpl->assign('xcontact_module_url',     XOOPS_URL . '/modules/xcontact/');
$xoopsTpl->assign('xoops_pagetitle',       $xoopsModule->getVar('name'));
$xoopsTpl->assign('xcontact_lang_no_forms',  _MD_XCONTACT_NO_FORMS);
$xoopsTpl->assign('xcontact_lang_fill_form', _MD_XCONTACT_FILL_FORM);

require_once XOOPS_ROOT_PATH . '/footer.php';
