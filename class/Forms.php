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
 * @author       TDM XOOPS - Email:info@email.com - Website:http://xoops.org
 */

use XoopsModules\Xcontact;

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
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormForms($action = false)
    {
        $helper = \XoopsModules\Xcontact\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $isAdmin = \is_object($GLOBALS['xoopsUser']) && $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        // Title
        $title = $this->isNew() ? \_AM_XCONTACT_FORMS_ADD : \_AM_XCONTACT_FORMS_EDIT;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text xxxName
        $form->addElement(new \XoopsFormText(\_AM_XCONTACT_FORMS_NAME, 'name', 50, 255, $this->getVar('name')), true);
        // Form Text xxxSlug
        $form->addElement(new \XoopsFormText(\_AM_XCONTACT_FORMS_SLUG, 'slug', 50, 255, $this->getVar('slug')));
        // Form Editor TextArea xxxDescription
        $form->addElement(new \XoopsFormTextArea(\_AM_XCONTACT_FORMS_DESCRIPTION, 'description', $this->getVar('description', 'e'), 4, 47), true);
        // Form Editor TextArea xxxFields
        $form->addElement(new \XoopsFormTextArea(\_AM_XCONTACT_FORMS_FIELDS, 'fields', $this->getVar('fields', 'e'), 4, 47));
        // Form Editor TextArea xxxSettings
        $form->addElement(new \XoopsFormTextArea(\_AM_XCONTACT_FORMS_SETTINGS, 'settings', $this->getVar('settings', 'e'), 4, 47));
        // Form Text xxxIs_active
        $xxxIs_active = $this->isNew() ? '1' : $this->getVar('is_active');
        $form->addElement(new \XoopsFormText(\_AM_XCONTACT_FORMS_IS_ACTIVE, 'is_active', 20, 150, $xxxIs_active));
        // Form Text Date Select xxxCreated_at
        $xxxCreated_at = $this->isNew() ? \time() : $this->getVar('created_at');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_XCONTACT_FORMS_CREATED_AT, 'created_at', '', $xxxCreated_at));
        // Form Select User xxxSubmitter
        $uidCurrent = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
        $xxxSubmitter = $this->isNew() ? $uidCurrent : $this->getVar('submitter');
        $form->addElement(new \XoopsFormSelectUser(\_AM_XCONTACT_FORMS_SUBMITTER, 'submitter', false, $xxxSubmitter));
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
    public function getValuesForms($keys = null, $format = null, $maxDepth = null)
    {
        return $this->getValues($keys, $format, $maxDepth);;
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
