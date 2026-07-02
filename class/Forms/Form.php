<?php

namespace XoopsModules\Xcontact\Forms;

/**
 * XOOPS Form Element
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       (c) 2000-2016 XOOPS Project (www.xoops.org)
 * @license             GNU GPL 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author              Goffy (Webdesign Gabor) https://wedega.com
 */

use XoopsFormText;

\defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * base class
 */
\xoops_load('XoopsThemeForm');

/**
 * Create hidden form button
 */
class Form extends \XoopsThemeForm
{

    /**
     * Render support for XoopsThemeForm
     *
     * @param XoopsThemeForm $form form to render
     *
     * @return string rendered form
     */
    public function render()
    {
        $ele_name = $this->getName();

        $ret = '<div class="clear"></div>';
        $ret .= '<div>';
        $ret .= '<form name="' . $ele_name . '" id="' . $ele_name . '" action="'
            . $this->getAction() . '" method="' . $this->getMethod()
            . '" onsubmit="return xoopsFormValidate_' . $ele_name . '();"' . $this->getExtra() . '>'
            . '<h3>' . $this->getTitle() . '</h3>';
        $hidden   = '';

        $ret .= '<div class="xcontact-grid">';
        foreach ($this->getElements() as $element) {
            if (!is_object($element)) { // see $this->addBreak()
                $ret .= $element;
                continue;
            }
            if ($element->isHidden()) {
                $hidden .= $element->render();
                continue;
            }

            $ret .= $element->render();
        }
        if (count($this->getRequired()) > 0) {
            //  Add caption marker constructed using renderer's formatting
            $ret .= '<div class="col-12 mb-2"> <span class="xo-caption-required">*</span> = ' . _REQUIRED . '</div>' . NWLINE;
        }
        $ret .= $hidden;
        $ret .= '</form></div>';
        $ret .= '</div>'; //<div class="xcontact-grid">';
        $ret .= $this->renderValidationJS(true);

        return $ret;
    }

}
