<?php

declare(strict_types=1);


namespace XoopsModules\Xcontact;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xContact module for xoops
 *
 * @copyright    2026 XOOPS Project (https://xoops.org)
 * @license      GPL 2.0 or later
 * @package      xcontact
 * @author       Eren Yumak — Aymak (aymak.net) / Goffy (wedega.com)
 */

use XoopsModules\Xcontact\Helper;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Submissions
 */
class Submissions extends \XoopsObject
{
    /**
     * @var int
     */
    public $start = 0;

    /**
     * @var int
     */
    public $limit = 0;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->initVar('sub_id', \XOBJ_DTYPE_INT);
        $this->initVar('form_id', \XOBJ_DTYPE_INT);
        $this->initVar('data', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('ip', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('status', \XOBJ_DTYPE_INT);
        $this->initVar('created_at', \XOBJ_DTYPE_INT);
    }

    /**
     * @static function getInstance
     *
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * The new inserted $Id
     * @return int
     */
    public function getNewInsertedIdSubmissions()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
        return $newInsertedId;
    }

    /**
     * Get Values
     * @param string $keys
     * @param string $format
     * @param string $maxDepth
     * @return array
     */
    public function getValuesSubmissions($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = Helper::getInstance();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $formsHandler = $helper->getHandler('Forms');
        $formsObj = $formsHandler->get($this->getVar('form_id'));
        $formName = \_AM_XCONTACT_INVALID_FORM_ID;
        if (\is_object($formsObj)) {
            $formName = $formsObj->getVar('name');
        }
        $ret['form_name']        = $formName;
        $ret['data_arr']         = json_decode($this->getVar('data', 'n'), true) ?: [];
        $ret['created_at_text']  = \formatTimestamp($this->getVar('created_at'), 's');

        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArraySubmissions()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar($var);
        }
        return $ret;
    }
}
