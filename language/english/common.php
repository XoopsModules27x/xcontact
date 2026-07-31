<?php declare(strict_types=1);
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * xcontact module
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @since           3.23
 * @author          Xoops Development Team
 */
$moduleDirName      = \basename(\dirname(__DIR__, 2));
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);

\define('_CO_XCONTACT_GDLIBSTATUS', 'GD library support: ');
\define('_CO_XCONTACT_GDLIBVERSION', 'GD Library version: ');
\define('_CO_XCONTACT_GDOFF', "<span style='font-weight: bold;'>Disabled</span> (No thumbnails available)");
\define('_CO_XCONTACT_GDON', "<span style='font-weight: bold;'>Enabled</span> (Thumbnails available)");
\define('_CO_XCONTACT_IMAGEINFO', 'Server status');
\define('_CO_XCONTACT_MAXPOSTSIZE', 'Max post size permitted (post_max_size directive in php.ini): ');
\define('_CO_XCONTACT_MAXUPLOADSIZE', 'Max upload size permitted (upload_max_filesize directive in php.ini): ');
\define('_CO_XCONTACT_MEMORYLIMIT', 'Memory limit (memory_limit directive in php.ini): ');
\define('_CO_XCONTACT_METAVERSION', "<span style='font-weight: bold;'>Downloads meta version:</span> ");
\define('_CO_XCONTACT_OFF', "<span style='font-weight: bold;'>OFF</span>");
\define('_CO_XCONTACT_ON', "<span style='font-weight: bold;'>ON</span>");
\define('_CO_XCONTACT_SERVERPATH', 'Server path to XOOPS root: ');
\define('_CO_XCONTACT_SERVERUPLOADSTATUS', 'Server uploads status: ');
\define('_CO_XCONTACT_SPHPINI', "<span style='font-weight: bold;'>Information taken from PHP ini file:</span>");
\define('_CO_XCONTACT_UPLOADPATHDSC', 'Note. Upload path *MUST* contain the full server path of your upload folder.');

\define('_CO_XCONTACT_PRINT', "<span style='font-weight: bold;'>Print</span>");
\define('_CO_XCONTACT_PDF', "<span style='font-weight: bold;'>Create PDF</span>");

\define('_CO_XCONTACT_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
\define('_CO_XCONTACT_UPGRADEFAILED1', "Update failed - couldn't add new fields");
\define('_CO_XCONTACT_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
\define('_CO_XCONTACT_ERROR_COLUMN', 'Could not create column in database : %s');
\define('_CO_XCONTACT_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
\define('_CO_XCONTACT_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
\define('_CO_XCONTACT_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');

\define('_CO_XCONTACT_FOLDERS_DELETED_OK', 'Upload Folders have been deleted');

// Error Msgs
\define('_CO_XCONTACT_ERROR_BAD_DEL_PATH', 'Could not delete %s directory');
\define('_CO_XCONTACT_ERROR_BAD_REMOVE', 'Could not delete %s');
\define('_CO_XCONTACT_ERROR_NO_PLUGIN', 'Could not load plugin');

//Help
\define('_CO_XCONTACT_DIRNAME', \basename(\dirname(__DIR__, 2)));
\define('_CO_XCONTACT_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
\define('_CO_XCONTACT_BACK_2_ADMIN', 'Back to Administration of ');
\define('_CO_XCONTACT_OVERVIEW', 'Overview');

//\define('_CO_XCONTACT_HELP_DIR', __DIR__);

//help multi-page
\define('_CO_XCONTACT_DISCLAIMER', 'Disclaimer');
\define('_CO_XCONTACT_LICENSE', 'License');
\define('_CO_XCONTACT_SUPPORT', 'Support');

//Sample Data
\define('_CO_XCONTACT_ADD_SAMPLEDATA', 'Import Sample Data (will delete ALL current data)');
\define('_CO_XCONTACT_SAMPLEDATA_SUCCESS', 'Sample Data imported successfully');
\define('_CO_XCONTACT_SAVE_SAMPLEDATA', 'Export Tables to YAML');
\define('_CO_XCONTACT_SAVE_SAMPLEDATA_SUCCESS', 'Export Tables to YAML successfully');
\define('_CO_XCONTACT_SAVE_SAMPLEDATA_ERROR', 'ERROR: Export of Tables to YAML failed');
\define('_CO_XCONTACT_SHOW_SAMPLE_BUTTON', 'Show Sample Button?');
\define('_CO_XCONTACT_SHOW_SAMPLE_BUTTON_DESC', 'If yes, the "Add Sample Data" button will be visible to the Admin. It is Yes as a default for first installation.');
\define('_CO_XCONTACT_EXPORT_SCHEMA', 'Export DB Schema to YAML');
\define('_CO_XCONTACT_EXPORT_SCHEMA_SUCCESS', 'Export DB Schema to YAML was a success');
\define('_CO_XCONTACT_EXPORT_SCHEMA_ERROR', 'ERROR: Export of DB Schema to YAML failed');
\define('_CO_XCONTACT_ADD_SAMPLEDATA_OK', 'Are you sure to Import Sample Data? (It will delete ALL current data)');
\define('_CO_XCONTACT_HIDE_SAMPLEDATA_BUTTONS', 'Hide the Import buttons');
\define('_CO_XCONTACT_SHOW_SAMPLEDATA_BUTTONS', 'Show the Import buttons');
\define('_CO_XCONTACT_CONFIRM', 'Confirm');

//letter choice
\define('_CO_XCONTACT_BROWSETOTOPIC', "<span style='font-weight: bold;'>Browse items alphabetically</span>");
\define('_CO_XCONTACT_OTHER', 'Other');
\define('_CO_XCONTACT_ALL', 'All');

// block defines
\define('_CO_XCONTACT_ACCESSRIGHTS', 'Access Rights');
\define('_CO_XCONTACT_ACTION', 'Action');
\define('_CO_XCONTACT_ACTIVERIGHTS', 'Active Rights');
\define('_CO_XCONTACT_BADMIN', 'Block Administration');
\define('_CO_XCONTACT_BLKDESC', 'Description');
\define('_CO_XCONTACT_CBCENTER', 'Center Middle');
\define('_CO_XCONTACT_CBLEFT', 'Center Left');
\define('_CO_XCONTACT_CBRIGHT', 'Center Right');
\define('_CO_XCONTACT_SBLEFT', 'Left');
\define('_CO_XCONTACT_SBRIGHT', 'Right');
\define('_CO_XCONTACT_SIDE', 'Alignment');
\define('_CO_XCONTACT_TITLE', 'Title');
\define('_CO_XCONTACT_VISIBLE', 'Visible');
\define('_CO_XCONTACT_VISIBLEIN', 'Visible In');
\define('_CO_XCONTACT_WEIGHT', 'Weight');

\define('_CO_XCONTACT_PERMISSIONS', 'Permissions');
\define('_CO_XCONTACT_BLOCKS', 'Blocks Admin');
\define('_CO_XCONTACT_BLOCKS_DESC', 'Blocks/Group Admin');

\define('_CO_XCONTACT_BLOCKS_MANAGMENT', 'Manage');
\define('_CO_XCONTACT_BLOCKS_ADDBLOCK', 'Add a new block');
\define('_CO_XCONTACT_BLOCKS_EDITBLOCK', 'Edit a block');
\define('_CO_XCONTACT_BLOCKS_CLONEBLOCK', 'Clone a block');

//myblocksadmin
\define('_CO_XCONTACT_AGDS', 'Admin Groups');
\define('_CO_XCONTACT_BCACHETIME', 'Cache Time');
\define('_CO_XCONTACT_BLOCKS_ADMIN', 'Blocks Admin');

//Template Admin
\define('_CO_XCONTACT_TPLSETS', 'Template Management');
\define('_CO_XCONTACT_GENERATE', 'Generate');
\define('_CO_XCONTACT_FILENAME', 'File Name');

//Menu
\define('_CO_XCONTACT_ADMENU_MIGRATE', 'Migrate');
\define('_CO_XCONTACT_FOLDER_YES', 'Folder "%s" exist');
\define('_CO_XCONTACT_FOLDER_NO', 'Folder "%s" does not exist. Create the specified folder with CHMOD 777.');
\define('_CO_XCONTACT_SHOW_DEV_TOOLS', 'Show Development Tools Button?');
\define('_CO_XCONTACT_SHOW_DEV_TOOLS_DESC', 'If yes, the "Migrate" Tab and other Development tools will be visible to the Admin.');
\define('_CO_XCONTACT_ADMENU_FEEDBACK', 'Feedback');

//Latest Version Check
\define('_CO_XCONTACT_NEW_VERSION', 'New Version: ');

//DirectoryChecker
\define('_CO_XCONTACT_AVAILABLE', "<span style='color: green;'>Available</span>");
\define('_CO_XCONTACT_NOTAVAILABLE', "<span style='color: red;'>Not available</span>");
\define('_CO_XCONTACT_NOTWRITABLE', "<span style='color: red;'>Should have permission ( %d ), but it has ( %d )</span>");
\define('_CO_XCONTACT_CREATETHEDIR', 'Create it');
\define('_CO_XCONTACT_SETMPERM', 'Set the permission');
\define('_CO_XCONTACT_DIRCREATED', 'The directory has been created');
\define('_CO_XCONTACT_DIRNOTCREATED', 'The directory cannot be created');
\define('_CO_XCONTACT_PERMSET', 'The permission has been set');
\define('_CO_XCONTACT_PERMNOTSET', 'The permission cannot be set');

//FileChecker
//\define('_CO_XCONTACT_AVAILABLE', "<span style='color: green;'>Available</span>");
//\define('_CO_XCONTACT_NOTAVAILABLE', "<span style='color: red;'>Not available</span>");
//\define('_CO_XCONTACT_NOTWRITABLE', "<span style='color: red;'>Should have permission ( %d ), but it has ( %d )</span>");
//\define('_CO_XCONTACT_COPYTHEFILE', 'Copy it');
//\define('_CO_XCONTACT_CREATETHEFILE', 'Create it');
//\define('_CO_XCONTACT_SETMPERM', 'Set the permission');

\define('_CO_XCONTACT_FILECOPIED', 'The file has been copied');
\define('_CO_XCONTACT_FILENOTCOPIED', 'The file cannot be copied');

//\define('_CO_XCONTACT_PERMSET', 'The permission has been set');
//\define('_CO_XCONTACT_PERMNOTSET', 'The permission cannot be set');

//image config
\define('_CO_XCONTACT_IMAGE_WIDTH', 'Image Display Width');
\define('_CO_XCONTACT_IMAGE_WIDTH_DSC', 'Display width for image');
\define('_CO_XCONTACT_IMAGE_HEIGHT', 'Image Display Height');
\define('_CO_XCONTACT_IMAGE_HEIGHT_DSC', 'Display height for image');
\define('_CO_XCONTACT_IMAGE_CONFIG', '<span style="color: #FF0000; font-size: Small;  font-weight: bold;">--- EXTERNAL Image configuration ---</span> ');
\define('_CO_XCONTACT_IMAGE_CONFIG_DSC', '');
\define('_CO_XCONTACT_IMAGE_UPLOAD_PATH', 'Image Upload path');
\define('_CO_XCONTACT_IMAGE_UPLOAD_PATH_DSC', 'Path for uploading images');

//Preferences
\define('_CO_XCONTACT_TRUNCATE_LENGTH', 'Number of Characters to truncate to the long text field');
\define('_CO_XCONTACT_TRUNCATE_LENGTH_DESC', 'Set the maximum number of characters to truncate the long text fields');

//Module Stats
\define('_CO_XCONTACT_STATS_SUMMARY', 'Module Statistics');
\define('_CO_XCONTACT_TOTAL_CATEGORIES', 'Categories:');
\define('_CO_XCONTACT_TOTAL_ITEMS', 'Items');
\define('_CO_XCONTACT_TOTAL_OFFLINE', 'Offline');
\define('_CO_XCONTACT_TOTAL_PUBLISHED', 'Published');
\define('_CO_XCONTACT_TOTAL_REJECTED', 'Rejected');
\define('_CO_XCONTACT_TOTAL_SUBMITTED', 'Submitted');
