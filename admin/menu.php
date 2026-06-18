<?php
/**
 * xcontact — Admin menu
 */

$path = dirname(__DIR__, 3);
$pathLanguage = XOOPS_ROOT_PATH . '/modules/xcontact/language/';

$fileinc = $pathLanguage . $GLOBALS['xoopsConfig']['language'] . '/admin.php';
if (!file_exists($fileinc)) {
    $fileinc = $pathLanguage . 'english/admin.php';
}
include_once $fileinc;

use Xmf\Module\Admin;
$pathIcon32 = Admin::menuIconPath('');

$helper = \XoopsModules\Xcontact\Helper::getInstance();

$adminmenu = [];
$adminmenu[] = ['title' => _AM_XCONTACT_MENU_MAIN,        'link' => 'admin/index.php',       'icon' => $pathIcon32 . 'home.png'];
$adminmenu[] = ['title' => _AM_XCONTACT_MENU_FORMS,       'link' => 'admin/forms.php',       'icon' => $pathIcon32 . 'content.png'];
$adminmenu[] = ['title' => _AM_XCONTACT_MENU_SUBMISSIONS, 'link' => 'admin/submissions.php', 'icon' => $pathIcon32 . 'search.png'];
if ($helper->getConfig('displayTabClone')) {
    $adminmenu[] = ['title' => _AM_XCONTACT_MENU_CLONE,       'link' => 'admin/clone.php',       'icon' => $pathIcon32 . 'page_copy.png'];
}
if ($helper->getConfig('displayTabFeedback')) {
    $adminmenu[] = ['title' => _AM_XCONTACT_MENU_FEEDBACK,       'link' => 'admin/feedback.php',       'icon' => $pathIcon32 . 'mail_foward.png'];
}
$adminmenu[] = ['title' => _AM_XCONTACT_MENU_ABOUT,       'link' => 'admin/about.php',       'icon' => $pathIcon32 . 'about.png'];
