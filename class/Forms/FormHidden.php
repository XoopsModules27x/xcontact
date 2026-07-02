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

use XoopsFormHidden;

\defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * base class
 */
\xoops_load('XoopsFormHidden');

/**
 * Create hidden form field
 */
class FormHidden extends \XoopsFormHidden
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
     * create HTML to output the hidden field
     *
     * @return string
     */
    public function render()
    {
        return '<input type="hidden" name="' . $this->getName() . '" value="' . $this->getValue() . '">';
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
