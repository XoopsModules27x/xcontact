<?php
/**
 * xcontact — Ön yüz: form listesi
 */

use Xmf\Request;

require_once '../../mainfile.php';
$xoopsOption['template_main'] = 'xcontact_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require __DIR__ . '/header.php';

$start  = Request::getInt('start');
$limit  = Request::getInt('limit', $helper->getConfig('userpager'));

$formsCount = $formsHandler->getCountForms();
if ($formsCount > 0) {
    $formsAll = $formsHandler->getAllForms($start, $limit);
    foreach (\array_keys($formsAll) as $i) {
        $forms = $formsAll[$i]->getValuesForms();
        $GLOBALS['xoopsTpl']->append('xcontact_list', $forms);
        unset($forms);
    }
}

$xoopsTpl->assign('xcontact_module_url',     \XCONTACT_URL . '/');
$xoopsTpl->assign('xoops_pagetitle',       $xoopsModule->getVar('name'));
$xoopsTpl->assign('xcontact_lang_no_forms',  _MD_XCONTACT_NO_FORMS);
$xoopsTpl->assign('xcontact_lang_fill_form', _MD_XCONTACT_FILL_FORM);

require_once XOOPS_ROOT_PATH . '/footer.php';
