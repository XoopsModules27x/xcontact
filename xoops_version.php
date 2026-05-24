<?php
/**
 * xcontact — İletişim Formu Oluşturucu — XOOPS 2.7.0
 * @package    xcontact
 * @author     Eren Yumak — Aymak (aymak.net)
 * @copyright  2025 Eren Yumak
 * @license    GPL 2.0
 */

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

$modversion = [];

$modversion['name']        = _MI_XCONTACT_NAME;
$modversion['version']     = '1.0.0';
$modversion['description'] = _MI_XCONTACT_DESC;
$modversion['author']      = 'Eren Yumak — Aymak';
$modversion['credits']     = 'Eren Yumak';
$modversion['license']     = 'GPL 2.0';
$modversion['official']    = 0;
$modversion['image']       = 'assets/images/logo.png';
$modversion['dirname']     = 'xcontact';
$modversion['hasAdmin']    = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';
$modversion['system_menu'] = 1;
$modversion['hasMain']     = 1;

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0]        = 'xcontact_forms';
$modversion['tables'][1]        = 'xcontact_submissions';

$modversion['onInstall']   = 'include/install.php';
$modversion['onUpdate']    = 'include/install.php';
$modversion['onUninstall'] = 'include/uninstall.php';

// ── Blok ─────────────────────────────────────────────────────────────────────
$modversion['blocks'][1] = [
    'file'      => 'xcontact_blocks.php',
    'name'      => _MI_XCONTACT_BLOCK_FORM,
    'show_func' => 'xcontact_block_form',
    'edit_func' => 'xcontact_block_form_edit',
    'options'   => 'none|0',
    'template'  => 'xcontact_block_form.tpl',
];

// ── Şablonlar ─────────────────────────────────────────────────────────────────
$modversion['templates'][1] = ['file' => 'xcontact_index.tpl',      'description' => 'Form listesi'];
$modversion['templates'][2] = ['file' => 'xcontact_form.tpl',       'description' => 'Form görüntüleme'];
// Block template templates/blocks/ klasöründe - XOOPS install sırasında otomatik tarar

// ── Modül ayarları ────────────────────────────────────────────────────────────
$modversion['config'][1] = [
    'name'      => 'upload_max_size',
    'title'     => '_MI_XCONTACT_CFG_UPLOAD_SIZE',
    'description' => '_MI_XCONTACT_CFG_UPLOAD_SIZE_DESC',
    'formtype'  => 'textbox',
    'valuetype' => 'int',
    'default'   => 5,
];

$modversion['config'][2] = [
    'name'      => 'captcha_length',
    'title'     => '_MI_XCONTACT_CFG_CAPTCHA_LEN',
    'description' => '_MI_XCONTACT_CFG_CAPTCHA_LEN_DESC',
    'formtype'  => 'textbox',
    'valuetype' => 'int',
    'default'   => 5,
];
