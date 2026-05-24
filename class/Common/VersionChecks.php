<?php declare(strict_types=1);

namespace XoopsModules\Xcontact\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright   2000-2026 XOOPS Project (https://xoops.org)
 * @license     GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author      mamba <mambax7@gmail.com>
 */
trait VersionChecks
{
    /**
     * Verifies XOOPS version meets minimum requirements for this module
     * @static
     *
     * @param null|string $requiredVer
     * @return bool true if meets requirements, false if not
     */
    public static function checkVerXoops(?\XoopsModule $module = null, $requiredVer = null): bool
    {
        if (null === $module) {
            $module = \XoopsModule::getByDirname(self::consumerDirname());
        }
        $moduleDirName      = (string)$module->getVar('dirname');
        $moduleDirNameUpper = \mb_strtoupper($moduleDirName);
        $errorConstant      = '_CO_XCONTACT_ERROR_BAD_XOOPS';
        if (!defined($errorConstant)) {
            $errorConstant = 'CO_XCONTACT_ERROR_BAD_XOOPS';
        }
        \xoops_loadLanguage('admin', $moduleDirName);
        \xoops_loadLanguage('common', $moduleDirName);

        //check for minimum XOOPS version
        $currentVer = mb_substr(\XOOPS_VERSION, 6); // get the numeric part of string
        if (null === $requiredVer) {
            $requiredVer = '' . $module->getInfo('min_xoops'); //making sure it's a string
        }
        $success = true;

        if ($module->versionCompare($currentVer, $requiredVer, '<')) {
            $success = false;
            $module->setErrors(\sprintf(\constant($errorConstant), $requiredVer, $currentVer));
        }

        return $success;
    }

    /**
     * Verifies PHP version meets minimum requirements for this module
     * @static
     * @param \XoopsModule|bool|null $module
     *
     * @return bool true if meets requirements, false if not
     */
    public static function checkVerPhp(?\XoopsModule $module = null): bool
    {
        if (null === $module) {
            $module = \XoopsModule::getByDirname(self::consumerDirname());
        }
        $moduleDirName      = (string)$module->getVar('dirname');
        $moduleDirNameUpper = \mb_strtoupper($moduleDirName);
        $errorConstant      = '_CO_XCONTACT_ERROR_BAD_PHP';
        if (!defined($errorConstant)) {
            $errorConstant = 'CO_XCONTACT_ERROR_BAD_PHP';
        }
        \xoops_loadLanguage('admin', $moduleDirName);
        \xoops_loadLanguage('common', $moduleDirName);

        // check for minimum PHP version
        $success = true;

        $verNum = \PHP_VERSION;
        $reqVer = &$module->getInfo('min_php');

        if (false !== $reqVer && '' !== $reqVer && !\is_array($reqVer)) {
            if (\version_compare($verNum, $reqVer, '<')) {
                $module->setErrors(\sprintf(\constant($errorConstant), $reqVer, $verNum));
                $success = false;
            }
        }

        return $success;
    }

    private static function consumerDirname(): string
    {
        $calledClass = static::class;
        if (preg_match('/^XoopsModules\\\\([^\\\\]+)/', $calledClass, $matches)) {
            return strtolower($matches[1]);
        }

        return 'xcontact';
    }
}
