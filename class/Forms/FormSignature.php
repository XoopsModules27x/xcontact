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
use XoopsModules\Xcontact\Icons;

\defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * base class
 */
\xoops_load('XoopsFormText');

/**
 * Create signature field
 */
class FormSignature extends \XoopsFormText
{
    
    /**
     * placeholder text
     *
     * @var string
     */
    private $placeholder;

    /**
     * colSize text
     *
     * @var string
     */
    private $colSize;

    /**
     * create HTML for input of signature
     *
     * @return string
     */
    public function render()
    {
        $iconDel = Icons::get('delete');
        $ret = '<div class="' . $this->getColsize() . '">';
        $ret .= '<div class="' . $this->getClass() . '">';
        $ret .= '<label class="xcontact-label"><span>' . $this->getCaption();
        if ($this->isRequired()) {
            $ret .=  '<span class="xcontact-req">*</span> ';
        }
        $ret .= '</span></label>';
        $ret .= '<canvas class="xcontact-sig-pad" id="sig_' . $this->getName() . '" width="600" height="150"></canvas>';
        $ret .= '<input type="hidden" name="' . $this->getName() . '" id="sig_data_' . $this->getName() . '">';
        $ret .= '<button type="button" class="xcontact-sig-clear" onclick="xcfSigClear(' . "'" . $this->getName() . "'" . ')">' . $iconDel . ' ' ._MD_XCONTACT_SIG_CLEAR . '</button>';
        if ('' != $this->getDescription()) {
            $ret .= '<p class="xcontact-hint">' . $this->getDescription() . '</p>';
        }
        $ret .= '</div>';
        $ret .= '</div>';

        return $ret;

    }

    /**
     * Get column size value
     *
     * @return string
     */
    public function getColsize() {

        return $this->colSize;

    }

    /**
     * Set column size value
     *
     * @param string $value
     */
    public function setColsize($value) {

        $this->colSize = $value;

    }

    /**
     * Get placeholder value
     *
     * @return string
     */
    public function getPlaceholder() {

        return $this->placeholder;

    }

    /**
     * Set placeholder value
     *
     * @param string $value
     */
    public function setPlaceholder($value) {

        $this->placeholder = $value;

    }

}
