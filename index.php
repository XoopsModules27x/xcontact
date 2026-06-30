<?php
/**
 * xcontact — Front page: list of forms
 */

use Xmf\Request;
use XoopsModules\Xcontact\Constants;

require_once '../../mainfile.php';
$xoopsOption['template_main'] = 'xcontact_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
require_once __DIR__ . '/include/functions.php';
require __DIR__ . '/header.php';

$start  = Request::getInt('start');
$limit  = Request::getInt('limit', $helper->getConfig('userpager'));

$crForms = new \CriteriaCompo();
$crForms->add(new \Criteria('is_active', Constants::FORM_IS_ACTIVE));
$formsCount = $formsHandler->getCount($crForms);
if ($formsCount > 0) {
    $crForms->setStart($start);
    $crForms->setLimit($limit);
    $crForms->setSort('form_id');
    $crForms->setOrder('DESC');
    $formsAll = $formsHandler->getAll($crForms);
    foreach (\array_keys($formsAll) as $i) {
        $forms = $formsAll[$i]->getValuesForms();
        $GLOBALS['xoopsTpl']->append('xcontact_list', $forms);
        unset($forms);
    }
    if ($formsCount > $limit) {
        require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
        $pagenav = new \XoopsPageNav($formsCount, $limit, $start, 'start');
        $xoopsTpl->assign('pagenav', $pagenav->renderNav());
    }
}

$xoopsTpl->assign('xcontact_module_url',     \XCONTACT_URL . '/');
$xoopsTpl->assign('xoops_pagetitle',       $xoopsModule->getVar('name'));
$xoopsTpl->assign('xcontact_lang_no_forms',  _MD_XCONTACT_NO_FORMS);
$xoopsTpl->assign('xcontact_lang_fill_form', _MD_XCONTACT_FILL_FORM);

require_once XOOPS_ROOT_PATH . '/footer.php';
