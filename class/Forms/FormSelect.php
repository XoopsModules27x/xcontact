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

use XoopsFormSelect;

\defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * base class
 */
\xoops_load('XoopsFormSelect');

/**
 * Create form select
 */
class FormSelect extends \XoopsFormSelect
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
     * input type
     *
     * @var string
     */
    private $inputType;

    /**
     * create HTML to output the select field
     *
     * @return string
     */
    public function render()
    {
        $ret = '<div class="' . $this->getColsize() . '">';
        $ret .= '<div class="' . $this->getClass() . '">';
        $ret .= '<label class="xcontact-label">' . $this->getCaption();
        if ($this->isRequired()) {
            $ret .=  '<span class="xcontact-req">*</span> ';
        }
        $ret .= '</label>';

        $ret .= '<select class="xcontact-choice-list" name="' . $this->getName() . '"';
        if ($this->isRequired()) {
            $ret .=  ' required ';
        }
        $ret .= $this->getExtra() . '>';

        $elementOptions = $this->getOptions();
        if (defined('_MD_XCONTACT_SELECT_OPT')) {
            $ret .= '<option value="">' . \_MD_XCONTACT_SELECT_OPT . '</option>';
        } else {
            $ret .= '<option value="">' . \_AM_XCONTACT_SELECT_OPT . '</option>';
        }

        foreach ($elementOptions as $value => $name) {
            $ret .= '<option value="' . $value . '">' . $name . '</option>';
        }

        if (($desc = $this->getDescription()) !== '') {
            $ret .= '<p class="xcontact-hint">' . $desc . '</p>';
        }
        $ret .= '</select>';
        $ret .= '</div>';
        $ret .= '</div>';

        return $ret;

    }

    /**
     * Get input type value
     *
     * @return string
     */
    public function getType() {

        return $this->inputType;

    }

    /**
     * Set input type value
     *
     * @param string $value
     */
    public function setType($value) {

        $this->inputType = $value;

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
