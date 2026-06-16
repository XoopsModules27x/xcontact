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

use XoopsModules\Xcontact;

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
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormSubmissions($action = false)
    {
        $helper = \XoopsModules\Xcontact\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $isAdmin = \is_object($GLOBALS['xoopsUser']) && $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        // Title
        $title = $this->isNew() ? \_AM_XCONTACT_SUBMISSIONS_ADD : \_AM_XCONTACT_SUBMISSIONS_EDIT;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Table forms
        $formsHandler = $helper->getHandler('Forms');
        $xxxForm_idSelect = new \XoopsFormSelect(\_AM_XCONTACT_SUBMISSIONS_FORM_ID, 'form_id', $this->getVar('form_id'));
        $xxxForm_idSelect->addOptionArray($formsHandler->getList());
        $form->addElement($xxxForm_idSelect, true);
        // Form Editor TextArea xxxData
        $form->addElement(new \XoopsFormTextArea(\_AM_XCONTACT_SUBMISSIONS_DATA, 'data', $this->getVar('data', 'e'), 4, 47), true);
        // Form Text IP xxxIp
        $xxxIp = $_SERVER['REMOTE_ADDR'];
        $xxxIp = $this->isNew() ? ($_SERVER['REMOTE_ADDR'] ?? '') : $this->getVar('ip');
        $form->addElement(new \XoopsFormText(\_AM_XCONTACT_SUBMISSIONS_IP, 'ip', 20, 150, $xxxIp), true);
        // Form Text xxxStatus
        $xxxStatus = $this->isNew() ? '0' : $this->getVar('status');
        $form->addElement(new \XoopsFormText(\_AM_XCONTACT_SUBMISSIONS_STATUS, 'status', 20, 150, $xxxStatus));
        // Form Text Date Select xxxCreated_at
        $xxxCreated_at = $this->isNew() ? \time() : $this->getVar('created_at');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_XCONTACT_SUBMISSIONS_CREATED_AT, 'created_at', '', $xxxCreated_at));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormHidden('start', $this->start));
        $form->addElement(new \XoopsFormHidden('limit', $this->limit));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
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
        $helper  = \XoopsModules\Xcontact\Helper::getInstance();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $formsHandler = $helper->getHandler('Forms');
        $formsObj = $formsHandler->get($this->getVar('form_id'));
        $formName = '';
        if (\is_object($formsObj)) {
            $formName = $formsObj->getVar('name');
        }
        $ret['form_name']        = $formName;
        $ret['data_text']        = \strip_tags($this->getVar('data', 'e'));
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
