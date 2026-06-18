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

use XoopsModules\Xcontact\Constants;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Forms
 */
class Forms extends \XoopsObject
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
        $this->initVar('form_id', \XOBJ_DTYPE_INT);
        $this->initVar('name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('slug', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('description', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('fields', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('settings', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('is_active', \XOBJ_DTYPE_INT);
        $this->initVar('created_at', \XOBJ_DTYPE_INT);
        $this->initVar('submitter', \XOBJ_DTYPE_INT);
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
    public function getNewInsertedIdForms()
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
    public function getValuesForms($keys = null, $format = null, $maxDepth = null)
    {

        $helper = \XoopsModules\Xcontact\Helper::getInstance();
        $submissionsHandler = $helper->getHandler('Submissions');
        $utility = new \XoopsModules\Xcontact\Utility();
        $truncateLength = $helper->getConfig('truncate_length');

        $ret =  $this->getValues($keys, $format, $maxDepth);

        // count fields
        $fields = json_decode($this->getVar('fields') ?: '[]', true) ?: [];
        $ret['field_count'] = count($fields);
        // get number of submissions total
        $crTotalSubs = new \CriteriaCompo();
        $crTotalSubs->add(new \Criteria('form_id', $this->getVar('form_id')));
        $ret['total_subs'] = $submissionsHandler->getCount($crTotalSubs);
        // get number of new submissions
        $crNewSubs = new \CriteriaCompo();
        $crNewSubs->add(new \Criteria('form_id', $this->getVar('form_id')));
        $crNewSubs->add(new \Criteria('status', Constants::SUBMISSION_NEW));
        $ret['new_subs'] = $submissionsHandler->getCount($crNewSubs);
        // get truncated description
        $ret['description_short'] = $utility::truncateHtml($ret['description'], $truncateLength);
        // misc
        $ret['tpl_tag'] = '{xcontact slug="' . $this->getVar('slug') . '"}';
        $ret['url']     = \XOOPS_URL . '/modules/xcontact/form.php?slug=' . urlencode($this->getVar('slug'));

        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayForms()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar($var);
        }
        return $ret;
    }
}
