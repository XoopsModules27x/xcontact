<?php declare(strict_types=1);
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

$moduleDirName      = \basename(\dirname(__DIR__, 2));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

define('_CO_XCONTACT_FC_AVAILABLE', "<span style='color: green;'>Available</span>");
define('_CO_XCONTACT_FC_NOTAVAILABLE', "<span style='color: red;'>Not available</span>");
define('_CO_XCONTACT_FC_NOTWRITABLE', "<span style='color: red;'>Should have permission ( %d ), but it has ( %d )</span>");
define('_CO_XCONTACT_FC_COPYTHEFILE', 'Copy it');
define('_CO_XCONTACT_FC_CREATETHEFILE', 'Create it');
define('_CO_XCONTACT_FC_SETMPERM', 'Set the permission');
define('_CO_XCONTACT_FC_FILECOPIED', 'The file has been copied');
define('_CO_XCONTACT_FC_FILENOTCOPIED', 'The file cannot be copied');
define('_CO_XCONTACT_FC_PERMSET', 'The permission has been set');
define('_CO_XCONTACT_FC_PERMNOTSET', 'The permission cannot be set');
