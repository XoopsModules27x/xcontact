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
 * @copyright      module for xoops
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use XoopsModules\Xcontact;
use XoopsModules\Xcontact\{
    Common,
    Constants
};

/**
 * @param \XoopsModule $module
 * @return bool
 */
function xoops_module_pre_install_xcontact(\XoopsModule $module): bool
{
    require \dirname(__DIR__) . '/preloads/autoloader.php';

    $utility = new Xcontact\Utility();

    //check for minimum XOOPS version
    $xoopsSuccess = $utility::checkVerXoops($module);

    // check for minimum PHP version
    $phpSuccess = $utility::checkVerPhp($module);

    return $xoopsSuccess && $phpSuccess;
}

/**
 * @param \XoopsModule $module
 * @return bool
 */
function xoops_module_install_xcontact(\XoopsModule $module): bool
{
    require \dirname(__DIR__) . '/preloads/autoloader.php';

    $helper       = Xcontact\Helper::getInstance();
    $utility      = new Xcontact\Utility();
    $configurator = new Common\Configurator();

    // Load language files
    $helper->loadLanguage('admin');
    $helper->loadLanguage('modinfo');
    $helper->loadLanguage('common');

    //  ---  CREATE FOLDERS ---------------
    if ($configurator->uploadFolders && \is_array($configurator->uploadFolders)) {
        foreach (\array_keys($configurator->uploadFolders) as $i) {
            $utility::createFolder($configurator->uploadFolders[$i]);
            if (\is_dir($configurator->uploadFolders[$i])) {
                chmod($configurator->uploadFolders[$i], 0755);
            }
        }
    }

    //  ---  COPY blank.gif FILES ---------------
    if ($configurator->copyBlankFiles && \is_array($configurator->copyBlankFiles)) {
        $file = \dirname(__DIR__) . '/assets/images/blank.gif';
        foreach (\array_keys($configurator->copyBlankFiles) as $i) {
            $dest = $configurator->copyBlankFiles[$i] . '/blank.gif';
            $utility::copyFile($file, $dest);
        }
    }

    // Smarty compile cache temizle
    foreach ([
                 XOOPS_ROOT_PATH . '/../xoops_data/caches/smarty_compile',
                 XOOPS_ROOT_PATH . '/xoops_data/caches/smarty_compile',
             ] as $dir) {
        if (!is_dir($dir)) continue;
        foreach (new RecursiveIteratorIterator(
                     new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
                     RecursiveIteratorIterator::CHILD_FIRST
                 ) as $f) {
            if ($f->isFile() && $f->getExtension() === 'php') @unlink($f->getPathname());
        }
    }

    $dir = XOOPS_ROOT_PATH . '/uploads/xcontact';
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) return false;
    $htaccess = $dir . '/.htaccess';
    if (!file_exists($htaccess)) {
        file_put_contents($htaccess, <<<HTACCESS
            Options -Indexes
            
            <FilesMatch "(?i)\.(php\d*|phtml|phar|phps|pht|phtm)$">
                Require all denied
            </FilesMatch>
            
            <FilesMatch "\.(jpg|jpeg|png|gif|webp|svg|ico|bmp|avif)$">
                Require all granted
            </FilesMatch>
            HTACCESS);
    }

    return true;
}



