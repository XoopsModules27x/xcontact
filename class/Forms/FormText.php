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
\xoops_load('XoopsFormText');

/**
 * Create form text input
 */
class FormText extends \XoopsFormText
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
     * create HTML to output the text field
     *
     * @return string
     */
    public function render()
    {
        $ret = '<div class="' . $this->getColsize() . '">';
        $ret .= '<div class="' . $this->getClass() . '">';
        $ret .= '<label class="xcontact-label" for="xcf_' . $this->getName() . '"><span>' . $this->getCaption();
        if ($this->isRequired()) {
            $ret .=  '<span class="xcontact-req">*</span> ';
        }
        $ret .= '</span></label>';
        $ret .=  '<input id="xcf_' . $this->getName() . '" type="' . $this->getType() . '" name="'  . $this->getName() . '"';
        if ($this->placeholder) {
            $ret .= ' placeholder="' . $this->getPlaceholder() . '"';
        }
        $ret .=  ' value="' . $this->getValue() . '"';
        if ($this->isRequired()) {
            $ret .=  ' required ';
        }
        $ret .=  ' title="' . $this->getTitle() . '"';

        if ($this->_hidden) {
            $ret .= ' style="display:none" ';
        }

        $ret .= ' />';
        if (($desc = $this->getDescription()) !== '') {
            $ret .= '<p class="xcontact-hint">' . $desc . '</p>';
        }
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
