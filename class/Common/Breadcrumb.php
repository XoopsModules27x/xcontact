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
 * Breadcrumb Class
 *
 * @copyright   2000-2026 XOOPS Project (https://xoops.org)
 * @license     GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author      lucio <lucio.rota@gmail.com>
 *
 * Example:
 * $breadcrumb = new Breadcrumb();
 * $breadcrumb->addLink( 'bread 1', 'index1.php' );
 * $breadcrumb->addLink( 'bread 2', '' );
 * $breadcrumb->addLink( 'bread 3', 'index3.php' );
 * echo $breadcrumb->render();
 */

/**
 * Class Breadcrumb
 */
class Breadcrumb
{
    public string $dirname;
    private array $bread = [];
    private string $template;

    public function __construct(?string $dirname = null, ?string $template = null)
    {
        $this->dirname  = $dirname ? basename($dirname) : \basename(\dirname(__DIR__, 2));
        $this->template = $template ?: $this->dirname . '_common_breadcrumb.tpl';
    }

    /**
     * Add link to breadcrumb
     *
     * @param string $title
     * @param string $link
     */
    public function addLink($title = '', $link = ''): void
    {
        $this->bread[] = [
            'link'  => $link,
            'title' => $title,
        ];
    }

    /**
     * Render BreadCrumb
     * @return array|bool|mixed|string|string[]|void
     */
    public function render()
    {
        if (!isset($GLOBALS['xoTheme']) || !\is_object($GLOBALS['xoTheme'])) {
            require $GLOBALS['xoops']->path('class/theme.php');
            $GLOBALS['xoTheme'] = new \xos_opal_Theme();
        }

        require $GLOBALS['xoops']->path('class/template.php');
        $breadcrumbTpl = new \XoopsTpl();
        $breadcrumbTpl->assign('breadcrumb', $this->bread);
        $html = $breadcrumbTpl->fetch('db:' . $this->template);
        unset($breadcrumbTpl);

        return $html;
    }
}
