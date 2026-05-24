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
 * Xcontact module for xoops
 *
 * @param mixed      $module
 * @param null|mixed $prev_version
 * @copyright      module for xoops
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use XoopsModules\Xcontact;
use XoopsModules\Xcontact\Common\ {
    Configurator,
    Migrate,
    MigrateHelper
};

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_update_xcontact(\XoopsModule $module): bool
{
    $utility = new Xcontact\Utility();

    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPhp($module);

    return $xoopsSuccess && $phpSuccess;
}

/**
 * @param      $module
 * @param null $prev_version
 *
 * @return bool
 */
function xoops_module_update_xcontact($module, $prev_version = null):bool
{
    $ret = false;

    $moduleDirName = $module->dirname();

    /*
    if ($prev_version < 10) {
        //enter code or call your function
    }
    */
    $ret = xcontact_check_db($module);

    include_once __DIR__ . '/install.php';
    $ret = xoops_module_install_xcontact($module);

    // update DB corresponding to sql/mysql.sql
    $configurator = new Configurator();
    $migrate = new Migrate($configurator);

    $fileSql = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/sql/mysql.sql';
    // ToDo: add function setDefinitionFile to .\class\libraries\vendor\xoops\xmf\src\Database\Migrate.php
    // Todo: once we are using setDefinitionFile this part has to be adapted
    //$fileYaml = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/sql/update_' . $moduleDirName . '_migrate.yml';
    //try {
    //$migrate->setDefinitionFile('update_' . $moduleDirName);
    //} catch (\Exception $e) {
    // as long as this is not done default file has to be created
    $moduleVersionOld = $module->getInfo('version');
    $moduleVersionNew = \str_replace(['.', '-'], '_', $moduleVersionOld);
    $fileYaml = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . "/sql/{$moduleDirName}_{$moduleVersionNew}_migrate.yml";
    //}

    // create a schema file based on sql/mysql.sql
    $migratehelper = new MigrateHelper($fileSql, $fileYaml);
    if (!$migratehelper->createSchemaFromSqlfile()) {
        \xoops_error('Error: creation schema file failed!');
        return false;
    }

    //create copy for XOOPS 2.5.11 Beta 1 and older versions
    $fileYaml2 = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . "/sql/{$moduleDirName}_{$moduleVersionOld}_migrate.yml";
    \copy($fileYaml, $fileYaml2);

    // run standard procedure for db migration
    $migrate->synchronizeSchema();

    $errors = $module->getErrors();
    if (!empty($errors)) {
        print_r($errors);
    }

    return $ret;
}

/**
 * @param $module
 *
 * @return bool
 */
function xcontact_check_db($module): bool
{
    $ret = true;
    //insert here code for database check

    /*
    // Example: update table (add new field)
    $table   = $GLOBALS['xoopsDB']->prefix('xcontact_images');
    $field   = 'img_exif';
    $check   = $GLOBALS['xoopsDB']->queryF('SHOW COLUMNS FROM `' . $table . "` LIKE '" . $field . "'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        $sql = "ALTER TABLE `$table` ADD `$field` TEXT NULL AFTER `img_state`;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when adding '$field' to table '$table'.");
            $ret = false;
        }
    }

    // Example: create new table
    $table   = $GLOBALS['xoopsDB']->prefix('xcontact_categories');
    $check   = $GLOBALS['xoopsDB']->queryF("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$table'");
    $numRows = $GLOBALS['xoopsDB']->getRowsNum($check);
    if (!$numRows) {
        // create new table 'xcontact_categories'
        $sql = "CREATE TABLE `$table` (
                  `id`        INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                  `cat_text`      VARCHAR(100)    NOT NULL DEFAULT '',
                  `cat_date`      INT(8)          NOT NULL DEFAULT '0',
                  `submitter` INT(8)          NOT NULL DEFAULT '0',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB;";
        if (!$result = $GLOBALS['xoopsDB']->queryF($sql)) {
            xoops_error($GLOBALS['xoopsDB']->error() . '<br>' . $sql);
            $module->setErrors("Error when creating table '$table'.");
            $ret = false;
        }
    }
    */
    return $ret;
}
