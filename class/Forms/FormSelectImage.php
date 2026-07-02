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
 * Create form image select
 */
class FormSelectImage extends \XoopsFormSelect
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
     * create HTML to output the image select field
     *
     * @return string
     */
    public function render()
    {
        $ret = '<div class="' . $this->getColsize() . '">';
        $ret .= '<div class="' . $this->getClass() . '">';
        $ret .= '<label class="xcontact-label"><span>' . $this->getCaption();
        if ($this->isRequired()) {
            $ret .=  '<span class="xcontact-req">*</span> ';
        }
        $ret .= '</span></label>';

        $ret .= '<div class="xcontact-choice-list">';
        $ret .= '<div class="xcontact-fg-imgchoice-container">';

        $elementOptions = $this->getOptions();
        $selectedValue = $this->getValue();
        foreach ($elementOptions as $value => $name) {
            $ret .= '<label><input type="' . $this->getType() . '" name="' . $this->getName() . '[]" title="'
                . htmlspecialchars(strip_tags($name), ENT_QUOTES | ENT_HTML5) . '" value="'
                . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';

            if ($this->isRequired()) {
                $ret .=  ' required ';
            }
            if (is_array($selectedValue) && in_array($value, $selectedValue)) {
                $ret .= ' checked';
            } elseif ($value == $selectedValue) {
                $ret .= ' checked';
            }
            $ret .= $this->getExtra() . ' style="display:none">';
            $ret .= '<div class="xcontact-oi-container">';
            $ret .= '<img class="img-fluid img-responsive" src="' . \XCONTACT_UPLOAD_IMAGE_URL . '/' . rawurlencode($name) . '" alt="' . htmlspecialchars($name, ENT_QUOTES | ENT_HTML5) . '" title="' . htmlspecialchars($name, ENT_QUOTES | ENT_HTML5) . '">';
            $ret .= '</div>';
            $ret .= '</label>';
        }
        $ret .= '</div>';
        if (($desc = $this->getDescription()) !== '') {
            $ret .= '<p class="xcontact-hint">' . $desc . '</p>';
        }

        $ret .= '</div>';
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
