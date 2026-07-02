<?php
/**
 * xcontact — Contact Form Generator — XOOPS 2.7.0
 * @package    xcontact
 * @author     Eren Yumak — Aymak (aymak.net) / Goffy (wedega.com)
 * @copyright  2025 Eren Yumak
 * @license    GPL 2.0
 */

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

$moduleDirName      = \basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

include \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/preloads/autoloader.php';

$modversion = [
    'name'                => \_MI_XCONTACT_NAME,
    'version'             => '1.0.1',
    'description'         => \_MI_XCONTACT_DESC,
    'author'              => 'Eren Yumak — Aymak',
    'author_mail'         => 'aymak@aymak.net',
    'author_website_url'  => '',
    'author_website_name' => '',
    'credits'             => 'Eren Yumak — Aymak; Goffy',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.en.html',
    'help'                => 'page=help',
    'release_date'        => '2026/05/24',
    'manual'              => 'link to manual file',
    'manual_file'         => \XOOPS_URL . '/modules/xcontact/docs/install.txt',
    'min_php'             => '8.3',
    'min_xoops'           => '2.7.0',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '8.0', 'mysqli' => '8.0'],
    'image'               => 'assets/images/logo.png',
    'dirname'             => \basename(__DIR__),
    'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
    'sysicons16'          => '../../Frameworks/moduleclasses/icons/16',
    'sysicons32'          => '../../Frameworks/moduleclasses/icons/32',
    'modicons16'          => 'assets/icons/16',
    'modicons32'          => 'assets/icons/32',
    'demo_site_url'       => 'erenyumak.com',
    'demo_site_name'      => 'erenyumak.com',
    'support_url'         => 'xoops.org/modules/newbb',
    'support_name'        => 'Support Forum',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    'release'             => '2026-05-24',
    'module_status'       => 'Beta 1',
    'system_menu'         => 1,
    'hasAdmin'            => 1,
    'hasMain'             => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    'onInstall'           => 'include/install.php',
    'onUninstall'         => 'include/uninstall.php',
    'onUpdate'            => 'include/update.php',
    'official'            => 0,
];
// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables
$modversion['tables'][0]        = 'xcontact_forms';
$modversion['tables'][1]        = 'xcontact_submissions';

// ── Blocks ─────────────────────────────────────────────────────────────────────
$modversion['blocks'][1] = [
    'file'      => 'xcontact_blocks.php',
    'name'      => \_MI_XCONTACT_BLOCK_FORM,
    'show_func' => 'xcontact_block_form',
    'edit_func' => 'xcontact_block_form_edit',
    'options'   => 'none|0',
    'template'  => 'xcontact_block_form.tpl',
];

// ------------------- Templates ------------------- //
// Admin
$modversion['templates'] = [
    // Admin templates
    ['file' => 'xcontact_admin_about.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'xcontact_admin_clone.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'xcontact_admin_footer.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'xcontact_admin_form_edit.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'xcontact_admin_forms.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'xcontact_admin_header.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'xcontact_admin_index.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'xcontact_admin_sub_view.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'xcontact_admin_submissions.tpl', 'description' => '', 'type' => 'admin'],
];
// User
$modversion['templates'][] = ['file' => 'xcontact_index.tpl',      'description' => 'Form list'];
$modversion['templates'][] = ['file' => 'xcontact_form.tpl',       'description' => 'View form'];


// ── Module settings ────────────────────────────────────────────────────────────

// Admin pager
$modversion['config'][] = [
    'name'        => 'adminpager',
    'title'       => '_MI_XCONTACT_ADMIN_PAGER',
    'description' => '_MI_XCONTACT_ADMIN_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];
// Admin pager
$modversion['config'][] = [
    'name'        => 'userpager',
    'title'       => '_MI_XCONTACT_USER_PAGER',
    'description' => '_MI_XCONTACT_USER_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];
$modversion['config'][] = [
    'name'        => 'truncate_length',
    'title'       => '_MI_XCONTACT_TRUNCATE_LENGTH',
    'description' => '_MI_XCONTACT_TRUNCATE_LENGTH_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 80,
];
// create increment steps for file size
require_once __DIR__ . '/include/xoops_version.inc.php';
$iniPostMaxSize       = xcontactReturnBytes(\ini_get('post_max_size'));
$iniUploadMaxFileSize = xcontactReturnBytes(\ini_get('upload_max_filesize'));
$maxSize              = min($iniPostMaxSize, $iniUploadMaxFileSize);
if ($maxSize > 10000 * 1048576) {
    $increment = 500;
}
if ($maxSize <= 10000 * 1048576) {
    $increment = 200;
}
if ($maxSize <= 5000 * 1048576) {
    $increment = 100;
}
if ($maxSize <= 2500 * 1048576) {
    $increment = 50;
}
if ($maxSize <= 1000 * 1048576) {
    $increment = 10;
}
if ($maxSize <= 500 * 1048576) {
    $increment = 5;
}
if ($maxSize <= 100 * 1048576) {
    $increment = 2;
}
if ($maxSize <= 50 * 1048576) {
    $increment = 1;
}
if ($maxSize <= 25 * 1048576) {
    $increment = 0.5;
}
$optionMaxsize = [];
$i = $increment;
while ($i * 1048576 <= $maxSize) {
    $optionMaxsize[$i . ' ' . (defined('_MI_XCONTACT_SIZE_MB') ? _MI_XCONTACT_SIZE_MB : 'MB')] = $i * 1048576;
    $i += $increment;
}
// Uploads : maxsize of image
$modversion['config'][] = [
    'name'        => 'upload_max_size',
    'title'       => '_MI_XCONTACT_CFG_UPLOAD_SIZE',
    'description' => '_MI_XCONTACT_CFG_UPLOAD_SIZE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1048576,
    'options'     => $optionMaxsize,
];
// Uploads : mimetypes for upload file
require_once __DIR__ . '/class/MimeTypes.php';
$mimetypes = new XoopsModules\Xcontact\MimeTypes();

$modversion['config'][] = [
    'name'        => 'upload_mimetypes',
    'title'       => '_MI_XCONTACT_UPLOAD_TYPES',
    'description' => '_MI_XCONTACT_UPLOAD_TYPES_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => [
        'image/gif',
        'image/jpeg',
        'image/jpg',
        'image/jpe',
        'image/png',
        'application/pdf',
        'application/zip',
        'text/plain',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ],
    'options'     => $mimetypes::getList(),
];

$modversion['config'][] = [
    'name'        => 'upload_filetypes',
    'title'       => '_MI_XCONTACT_UPLOAD_TYPES',
    'description' => '_MI_XCONTACT_UPLOAD_TYPES_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => ['jpg','jpeg','png','gif','pdf','doc','docx','xls','xlsx','txt','zip'],
    'options' => [
        // images
        'bmp'   => 'bmp',
        'gif'   => 'gif',
        'jpeg'  => 'jpeg',
        'jpg'   => 'jpg',
        'jpe'   => 'jpe',
        'png'   => 'png',
        // documents
        'pdf'   => 'pdf',
        'doc'   => 'doc',
        'docx'  => 'docx',
        'txt'   => 'txt',
        // tables
        'xls'   => 'xls',
        'xlsx'  => 'xlsx',
        // archive
        'zip'   => 'zip',
    ],
];
//  jpg,png,pdf,doc,xls,txt,zip
$modversion['config'][] = [
    'name'        => 'captcha_length',
    'title'       => '_MI_XCONTACT_CFG_CAPTCHA_LEN',
    'description' => '_MI_XCONTACT_CFG_CAPTCHA_LEN_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 5,
];
$modversion['config'][] = [
    'name'        => 'iconset',
    'title'       => '_MI_XCONTACT_ICONSET',
    'description' => '_MI_XCONTACT_ICONSET_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'fontawesome',
    'options'     => [
        _MI_XCONTACT_ICONSET_FA      => 'fontawesome',
        _MI_XCONTACT_ICONSET_UNICODE => 'unicode',
    ],
];
// Make tab clone visible?
$modversion['config'][] = [
    'name'        => 'displayTabClone',
    'title'       => '_MI_' . $moduleDirNameUpper . '_' . 'SHOW_TAB_CLONE',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Make tab feedback visible?
$modversion['config'][] = [
    'name'        => 'displayTabFeedback',
    'title'       => '_MI_' . $moduleDirNameUpper . '_' . 'SHOW_TAB_FEEDBACK',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Make Sample button visible?
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => '_MI_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLEDATA_BUTTONS',
    'description' => '_MI_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLEDATA_BUTTONS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// config for notifications after submissions
$modversion['config'][] = [
    'name'        => 'notification_name',
    'title'       => '_MI_XCONTACT_NOTIFICATION_NAME',
    'description' => '_MI_XCONTACT_NOTIFICATION_NAME_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => _MI_XCONTACT_NOTIFICATION_NAME_DEFAULT . ' - ' . $GLOBALS['xoopsConfig']['sitename'],
];
$modversion['config'][] = [
    'name'        => 'notification_email',
    'title'       => '_MI_XCONTACT_NOTIFICATION_EMAIL',
    'description' => '_MI_XCONTACT_NOTIFICATION_EMAIL_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => _MI_XCONTACT_NOTIFICATION_EMAIL_DEFAULT . ($_SERVER['HTTP_HOST'] ?? 'localhost'),
];
