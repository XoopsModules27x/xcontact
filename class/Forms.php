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
        $this->initVar('xxx_form_id', \XOBJ_DTYPE_INT);
        $this->initVar('xxx_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('xxx_slug', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('xxx_description', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('xxx_fields', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('xxx_settings', \XOBJ_DTYPE_TXTAREA);
        $this->initVar('xxx_is_active', \XOBJ_DTYPE_INT);
        $this->initVar('xxx_created_at', \XOBJ_DTYPE_INT);
        $this->initVar('xxx_submitter', \XOBJ_DTYPE_INT);
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
        $form->addElement(new \XoopsFormText(\_AM_XCONTACT_FORMS_NAME, 'xxx_name', 50, 255, $this->getVar('xxx_name')), true);
        // Form Text xxxSlug
        $form->addElement(new \XoopsFormText(\_AM_XCONTACT_FORMS_SLUG, 'xxx_slug', 50, 255, $this->getVar('xxx_slug')));
        // Form Editor TextArea xxxDescription
        $form->addElement(new \XoopsFormTextArea(\_AM_XCONTACT_FORMS_DESCRIPTION, 'xxx_description', $this->getVar('xxx_description', 'e'), 4, 47), true);
        // Form Editor TextArea xxxFields
        $form->addElement(new \XoopsFormTextArea(\_AM_XCONTACT_FORMS_FIELDS, 'xxx_fields', $this->getVar('xxx_fields', 'e'), 4, 47));
        // Form Editor TextArea xxxSettings
        $form->addElement(new \XoopsFormTextArea(\_AM_XCONTACT_FORMS_SETTINGS, 'xxx_settings', $this->getVar('xxx_settings', 'e'), 4, 47));
        // Form Text xxxIs_active
        $xxxIs_active = $this->isNew() ? '1' : $this->getVar('xxx_is_active');
        $form->addElement(new \XoopsFormText(\_AM_XCONTACT_FORMS_IS_ACTIVE, 'xxx_is_active', 20, 150, $xxxIs_active));
        // Form Text Date Select xxxCreated_at
        $xxxCreated_at = $this->isNew() ? \time() : $this->getVar('xxx_created_at');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_XCONTACT_FORMS_CREATED_AT, 'xxx_created_at', '', $xxxCreated_at));
        // Form Select User xxxSubmitter
        $uidCurrent = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
        $xxxSubmitter = $this->isNew() ? $uidCurrent : $this->getVar('xxx_submitter');
        $form->addElement(new \XoopsFormSelectUser(\_AM_XCONTACT_FORMS_SUBMITTER, 'xxx_submitter', false, $xxxSubmitter));
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
        $helper  = \XoopsModules\Xcontact\Helper::getInstance();
        $utility = new \XoopsModules\Xcontact\Utility();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret['form_id']           = $this->getVar('xxx_form_id');
        $ret['name']              = $this->getVar('xxx_name');
        $ret['slug']              = $this->getVar('xxx_slug');
        $ret['description_text']  = \strip_tags($this->getVar('xxx_description', 'e'));
        $ret['description_short'] = $utility::truncateHtml($ret['description_text'], $editorMaxchar);
        $ret['fields_text']       = \strip_tags($this->getVar('xxx_fields', 'e'));
        $ret['fields_short']      = $utility::truncateHtml($ret['fields_text'], $editorMaxchar);
        $ret['settings_text']     = \strip_tags($this->getVar('xxx_settings', 'e'));
        $ret['settings_short']    = $utility::truncateHtml($ret['settings_text'], $editorMaxchar);
        $ret['is_active']         = $this->getVar('xxx_is_active');
        $ret['created_at_text']   = \formatTimestamp($this->getVar('xxx_created_at'), 's');
        $ret['submitter_text']    = \XoopsUser::getUnameFromId($this->getVar('xxx_submitter'));
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
