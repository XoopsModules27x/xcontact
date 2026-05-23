<?php
/**
 * xcform — Admin menu
 */

// Dil dosyasını menu.php içinde yükle (XOOPS menu.php'yi erken çağırır)
$langFile = XOOPS_ROOT_PATH . '/modules/xcform/language/turkish/admin.php';
if (!defined('_AM_XCFORM_MENU_MAIN')) {
    if (defined('_LANGCODE') && _LANGCODE !== 'turkish') {
        $altLang = XOOPS_ROOT_PATH . '/modules/xcform/language/' . _LANGCODE . '/admin.php';
        if (file_exists($altLang)) require_once $altLang;
        else require_once $langFile;
    } else {
        require_once $langFile;
    }
}
if (!defined('_AM_XCFORM_MENU_MAIN')) {
    // Fallback: sabit string
    define('_AM_XCFORM_MENU_MAIN',        'Ana Sayfa');
    define('_AM_XCFORM_MENU_FORMS',       'Form Listesi');
    define('_AM_XCFORM_MENU_NEW_FORM',    'Yeni Form');
    define('_AM_XCFORM_MENU_SUBMISSIONS', 'Gönderiler');
    define('_AM_XCFORM_MENU_ABOUT',       'Hakkında');
}

use Xmf\Module\Admin;
$pathIcon32 = Admin::menuIconPath('');

$adminmenu = [];
$adminmenu[] = ['title' => _AM_XCFORM_MENU_MAIN,        'link' => 'admin/index.php',       'icon' => $pathIcon32 . '/home.png'];
$adminmenu[] = ['title' => _AM_XCFORM_MENU_FORMS,       'link' => 'admin/forms.php',       'icon' => $pathIcon32 . '/content.png'];
$adminmenu[] = ['title' => _AM_XCFORM_MENU_NEW_FORM,    'link' => 'admin/form_edit.php',   'icon' => $pathIcon32 . '/add.png'];
$adminmenu[] = ['title' => _AM_XCFORM_MENU_SUBMISSIONS, 'link' => 'admin/submissions.php', 'icon' => $pathIcon32 . '/search.png'];
$adminmenu[] = ['title' => _AM_XCFORM_MENU_ABOUT,       'link' => 'admin/about.php',       'icon' => $pathIcon32 . '/about.png'];
