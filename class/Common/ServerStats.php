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
trait ServerStats
{
    /**
     * serverStats()
     */
    public static function getServerStats(): string
    {
        $moduleDirName      = self::consumerDirnameForStats();
        $moduleDirNameUpper = \mb_strtoupper($moduleDirName);
        \xoops_loadLanguage('common', $moduleDirName);
        $html = '';
        //        $sql   = 'SELECT metavalue';
        //        $sql   .= ' FROM ' . $GLOBALS['xoopsDB']->prefix('wfdownloads_meta');
        //        $sql   .= " WHERE metakey='version' LIMIT 1";
        //        $query = $GLOBALS['xoopsDB']->query($sql);
        //        list($meta) = (($GLOBALS['xoopsDB']->isResultSet($query) && ($query instanceof \mysqli_result)) ? $GLOBALS['xoopsDB']->fetchRow($query) : false);
        $html .= '<fieldset>';
        $html .= "<legend style='font-weight: bold; color: #900;'>" . \constant('_CO_XCONTACT_IMAGEINFO') . '</legend>';
        $html .= "<div style='padding: 8px;'>";
        //        $html .= '<div>' . constant('_CO_XCONTACT_METAVERSION') . $meta . "</div>";
        //        $html .= "<br>";
        //        $html .= "<br>";
        $html .= '<div>' . \constant('_CO_XCONTACT_SPHPINI') . '</div>';
        $html .= '<ul>';

        if (\function_exists('gd_info')) {
            $html  .= '<li>' . \constant('_CO_XCONTACT_GDLIBSTATUS') . '<span style="color: #008000;">' . \constant('_CO_XCONTACT_GDON') . '</span>';
            $gdlib = \gd_info();
            if (!empty(($gdlib))) {
                $html .= '<li>' . \constant('_CO_XCONTACT_GDLIBVERSION') . '<b>' . $gdlib['GD Version'] . '</b>';
            }
        } else {
            $html .= '<li>' . \constant('_CO_XCONTACT_GDLIBSTATUS') . '<span style="color: #ff0000;">' . \constant('_CO_XCONTACT_GDOFF') . '</span>';
        }

        //    $safemode = ini_get('safe_mode') ? constant('_CO_XCONTACT_ON') . constant('_CO_XCONTACT_SAFEMODEPROBLEMS : constant('_CO_XCONTACT_OFF');
        //    $html .= '<li>' . constant('_CO_XCONTACT_SAFEMODESTATUS . $safemode;

        //    $registerglobals = (!ini_get('register_globals')) ? "<span style=\"color: #008000;\">" . constant('_CO_XCONTACT_OFF') . '</span>' : "<span style=\"color: #ff0000;\">" . constant('_CO_XCONTACT_ON') . '</span>';
        //    $html .= '<li>' . constant('_CO_XCONTACT_REGISTERGLOBALS . $registerglobals;

        $downloads = \ini_get('file_uploads') ? '<span style="color: #008000;">' . \constant('_CO_XCONTACT_ON') . '</span>' : '<span style="color: #ff0000;">' . \constant('_CO_XCONTACT_OFF') . '</span>';
        $html      .= '<li>' . \constant('_CO_XCONTACT_' . 'SERVERUPLOADSTATUS') . $downloads;

        $html .= '<li>' . \constant('_CO_XCONTACT_' . 'MAXUPLOADSIZE') . ' <b><span style="color: #0000ff;">' . \ini_get('upload_max_filesize') . '</span></b>';
        $html .= '<li>' . \constant('_CO_XCONTACT_' . 'MAXPOSTSIZE') . ' <b><span style="color: #0000ff;">' . \ini_get('post_max_size') . '</span></b>';
        $html .= '<li>' . \constant('_CO_XCONTACT_' . 'MEMORYLIMIT') . ' <b><span style="color: #0000ff;">' . \ini_get('memory_limit') . '</span></b>';
        $html .= '</ul>';
        $html .= '<ul>';
        $html .= '<li>' . \constant('_CO_XCONTACT_' . 'SERVERPATH') . ' <b>' . XOOPS_ROOT_PATH . '</b>';
        $html .= '</ul>';
        $html .= '<br>';
        $html .= \constant('_CO_XCONTACT_' . 'UPLOADPATHDSC') . '';
        $html .= '</div>';
        $html .= '</fieldset><br>';

        return $html;
    }

    private static function consumerDirnameForStats(): string
    {
        $calledClass = static::class;
        if (preg_match('/^XoopsModules\\\\([^\\\\]+)/', $calledClass, $matches)) {
            return strtolower($matches[1]);
        }

        return isset($GLOBALS['xoopsModule']) && $GLOBALS['xoopsModule'] instanceof \XoopsModule
            ? (string)$GLOBALS['xoopsModule']->getVar('dirname')
            : 'xcontact';
    }
}
