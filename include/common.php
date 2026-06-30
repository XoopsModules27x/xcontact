<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xcontact module for xoops
 *
 * @copyright    2026 XOOPS Project (https://xoops.org)
 * @license      GPL 2.0 or later
 * @package      xcontact
 * @author       Goffy - wedega - Email:webmaster@wedega.com - Website:https://wedega.com
 */

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

if (!\defined('XOOPS_ICONS32_PATH')) {
    \define('XOOPS_ICONS32_PATH', \XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32');
}
if (!\defined('XOOPS_ICONS32_URL')) {
    \define('XOOPS_ICONS32_URL', \XOOPS_URL . '/Frameworks/moduleclasses/icons/32');
}
\define('XCONTACT_DIRNAME', 'xcontact');
\define('XCONTACT_PATH', \XOOPS_ROOT_PATH . '/modules/' . \XCONTACT_DIRNAME);
\define('XCONTACT_URL', \XOOPS_URL . '/modules/' . \XCONTACT_DIRNAME);
\define('XCONTACT_ICONS_PATH', \XCONTACT_PATH . '/assets/icons');
\define('XCONTACT_ICONS_URL', \XCONTACT_URL . '/assets/icons');
\define('XCONTACT_IMAGE_PATH', \XCONTACT_PATH . '/assets/images');
\define('XCONTACT_IMAGE_URL', \XCONTACT_URL . '/assets/images');
\define('XCONTACT_UPLOAD_PATH', \XOOPS_UPLOAD_PATH . '/' . \XCONTACT_DIRNAME);
\define('XCONTACT_UPLOAD_URL', \XOOPS_UPLOAD_URL . '/' . \XCONTACT_DIRNAME);
\define('XCONTACT_UPLOAD_FILE_PATH', \XCONTACT_UPLOAD_PATH . '/files');
\define('XCONTACT_UPLOAD_FILE_URL', \XCONTACT_UPLOAD_URL . '/files');
\define('XCONTACT_UPLOAD_IMAGE_PATH', \XCONTACT_UPLOAD_PATH . '/images');
\define('XCONTACT_UPLOAD_IMAGE_URL', \XCONTACT_UPLOAD_URL . '/images');
\define('XCONTACT_UPLOAD_TEMP_PATH', \XCONTACT_UPLOAD_PATH . '/temp');
\define('XCONTACT_UPLOAD_TEMP_URL', \XCONTACT_UPLOAD_URL . '/temp');
\define('XCONTACT_ADMIN', \XCONTACT_URL . '/admin/index.php');
$localLogo = \XCONTACT_IMAGE_URL . '/logo.png';
// Module Information
$copyright = "<a href='https://erenyumak.com' title='Eren Yumak — Aymak, for XOOPS' target='_blank'><img src='" . $localLogo . "' alt='Eren Yumak — Aymak, for XOOPS' ></a>";
//require_once \XOOPS_ROOT_PATH . '/class/xoopsrequest.php';

