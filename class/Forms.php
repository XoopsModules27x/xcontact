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


use XoopsModules\Xcontact\{
    Forms\FormElement,
    Captcha\CaptchaHandler,
    MimeTypes
};

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
        $this->initVar('title', \XOBJ_DTYPE_TXTBOX);
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
     * @public function getForm for UI
     * @param string $action
     * @param array  $formData
     * @param array  $formFields
     * @param array  $formSettings
     * @return \XoopsThemeForm
     */
    public function getFormUI(string $action, array $formData, array $formFields, array $formSettings)
    {
        $helper = \XoopsModules\Xcontact\Helper::getInstance();

        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $formId = $this->getVar('form_id');

        $form = new Forms\Form($this->getVar('title'), 'form_' . $formId, $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // get all fields with params
        foreach ($formFields as $cf_field) {
            $fieldName = $cf_field['name'];

            switch ($cf_field['type']) {
                case 'short_text':
                    $formEle[$fieldName] = new Forms\FormText($cf_field['label'],  $cf_field['name'], 0, 0, $formData[$fieldName] ?? '');
                    $formEle[$fieldName]->setType('text');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    if ('' != $cf_field['placeholder']) {
                        $formEle[$fieldName]->setPlaceholder($cf_field['placeholder']);
                    }
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'long_text':
                    $formEle[$fieldName] = new Forms\FormTextArea($cf_field['label'],  $cf_field['name'], $formData[$fieldName] ?? '',5, 50);
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    if ('' != $cf_field['placeholder']) {
                        $formEle[$fieldName]->setPlaceholder($cf_field['placeholder']);
                    }
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'email':
                    $formEle[$fieldName] = new Forms\FormText($cf_field['label'],  $cf_field['name'], 0, 0, $formData[$fieldName] ?? '');
                    $formEle[$fieldName]->setType('email');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    if ('' != $cf_field['placeholder']) {
                        $formEle[$fieldName]->setPlaceholder($cf_field['placeholder']);
                    }
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'website':
                    $formEle[$fieldName] = new Forms\FormText($cf_field['label'],  $cf_field['name'], 0, 0, $formData[$fieldName] ?? '');
                    $formEle[$fieldName]->setType('url');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    if ('' != $cf_field['placeholder']) {
                        $formEle[$fieldName]->setPlaceholder($cf_field['placeholder']);
                    }
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'phone':
                    $formEle[$fieldName] = new Forms\FormText($cf_field['label'],  $cf_field['name'], 0, 0, $formData[$fieldName] ?? '');
                    $formEle[$fieldName]->setType('tel');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    if ('' != $cf_field['placeholder']) {
                        $formEle[$fieldName]->setPlaceholder($cf_field['placeholder']);
                    }
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'number':
                    $formEle[$fieldName] = new Forms\FormText($cf_field['label'],  $cf_field['name'], 0, 0, $formData[$fieldName] ?? '');
                    $formEle[$fieldName]->setType('number');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'date':
                    $formEle[$fieldName] = new Forms\FormText($cf_field['label'],  $cf_field['name'], 0, 0, $formData[$fieldName] ?? '');
                    $formEle[$fieldName]->setType('date');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'time':
                    $formEle[$fieldName] = new Forms\FormText($cf_field['label'],  $cf_field['name'], 0, 0, $formData[$fieldName] ?? '');
                    $formEle[$fieldName]->setType('time');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'file':
                    $maxsize = (int)$helper->getConfig('upload_max_size');
                    $description = \_MD_XCONTACT_FORM_UPLOAD_SIZE . ($maxsize / 1048576) . ' ' . \_MD_XCONTACT_FORM_UPLOAD_SIZE_MB .  ' <br>';
                    $mimeTypesConfig = (array)$helper->getConfig('upload_mimetypes');
                    $mimetypes = new MimeTypes();
                    $mimetypesPoss = $mimetypes::getList();
                    $mimetypeKeys = array_keys(array_intersect($mimetypesPoss, $mimeTypesConfig));
                    $description .= \_MD_XCONTACT_FORM_UPLOAD_FILETYPE . implode(', ', $mimetypeKeys) .  ' <br>';
                    if ('' != $cf_field['description']) {
                        $description .= $cf_field['description'];
                    }
                    $formEle[$fieldName] = new Forms\FormFile($cf_field['label'],  $cf_field['name'], $maxsize);
                    $formEle[$fieldName]->setType('file');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg xcontact-fg-file');
                    $formEle[$fieldName]->setDescription($description);
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'hidden':
                    $formEle[$fieldName] = new Forms\FormHidden($cf_field['name'], $cf_field['value']);
                    $form->addElement($formEle[$fieldName]);
                    break;
                case 'radio':
                    $formEle[$fieldName] = new Forms\FormRadio($cf_field['label'],  $cf_field['name'], $formData[$fieldName] ?? '');
                    $formEle[$fieldName]->setType('radio');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    foreach ($cf_field['options'] as $option) {
                        $formEle[$fieldName]->addOption($option, $option);
                    }
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'choice':
                    $formEle[$fieldName] = new Forms\FormCheckbox($cf_field['label'],  $cf_field['name'], $formData[$fieldName] ?? []);
                    $formEle[$fieldName]->setType('checkbox');
                    $formEle[$fieldName]->setAsArray(true);
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    foreach ($cf_field['options'] as $option) {
                        $formEle[$fieldName]->addOption($option, $option);
                    }
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'image_choice':
                    $formEle[$fieldName] = new Forms\FormSelectImage($cf_field['label'],  $cf_field['name'], $formData[$fieldName] ?? []);
                    $formEle[$fieldName]->setType('checkbox');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    foreach ($cf_field['options'] as $option) {
                        $formEle[$fieldName]->addOption($option, $option);
                    }
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'dropdown':
                    $formEle[$fieldName] = new Forms\FormSelect($cf_field['label'],  $cf_field['name'], $formData[$fieldName] ?? '');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    foreach ($cf_field['options'] as $option) {
                        $formEle[$fieldName]->addOption($option, $option);
                    }
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'consent':
                    $formEle[$fieldName] = new Forms\FormCheckbox('',  $cf_field['name'], $formData[$fieldName] ?? '');
                    $formEle[$fieldName]->setType('checkbox');
                    $formEle[$fieldName]->setAsArray(false);
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    $formEle[$fieldName]->addOption(1, $cf_field['label']);

                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'signature':
                    $formEle[$fieldName] = new Forms\FormSignature($cf_field['label'],  $cf_field['name'], 0, 0, $formData[$fieldName] ?? '');
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg');
                    $formEle[$fieldName]->setDescription($cf_field['description']);
                    $form->addElement($formEle[$fieldName], (bool)$cf_field['required']);
                    break;
                case 'label':
                    $label = '<span>' . $cf_field['label'] . '</span>';
                    $formEle[$fieldName] = new Forms\FormLabel('', $label);
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg xcontact-fg-label');
                    $form->addElement($formEle[$fieldName]);
                    break;
                case 'heading':
                    $formEle[$fieldName] = new Forms\FormLabel('', $cf_field['label']);
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-heading');
                    $form->addElement($formEle[$fieldName]);
                    break;
                case 'paragraph':
                    $label = '<p>' . $cf_field['label'] . '</p>';
                    $formEle[$fieldName] = new Forms\FormLabel('', $label);
                    $formEle[$fieldName]->setColsize('xcontact-col-' . $cf_field['width']);
                    $formEle[$fieldName]->setClass('xcontact-fg xcontact-fg-paragraph');
                    $form->addElement($formEle[$fieldName]);
                    break;
                case '':
                default:
                    break;
            }
        }
        // captcha
        if ((bool)($formSettings['enable_captcha'] ?? false)) {
            $captchaHandler = new CaptchaHandler();
            $captcha = $captchaHandler->getInstance($helper->getConfig('captcha_type'));
            if ($element = $captcha->getFormElement()) {
                $form->addElement($element);
            }
        }
        // hidden elelments
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormHidden('cf_form_id', $formId));
        $form->addElement(new \XoopsFormHidden('slug', $this->getVar('slug')));
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

        $helper             = \XoopsModules\Xcontact\Helper::getInstance();
        $submissionsHandler = $helper->getHandler('Submissions');
        $truncateLength     = (int)$helper->getConfig('truncate_length');

        $ret =  $this->getValues($keys, $format, $maxDepth);

        // count fields
        $fieldsRaw = $this->getVar('fields', 'n') ?: '[]';
        $fields = json_decode($fieldsRaw, true) ?: [];
        $ret['fields_decoded'] = $fields;
        $ret['fields_text']    = $fieldsRaw;
        $ret['fields_count']   = count($fields);
        $settings = json_decode($this->getVar('settings', 'n') ?: '{}', true) ?: [];
        $ret['settings_decoded'] = $settings;
        // get number of submissions total
        $crTotalSubs = new \CriteriaCompo();
        $crTotalSubs->add(new \Criteria('form_id', $ret['form_id']));
        $ret['total_subs'] = $submissionsHandler->getCount($crTotalSubs);
        // get number of new submissions
        $crNewSubs = new \CriteriaCompo();
        $crNewSubs->add(new \Criteria('form_id', $ret['form_id']));
        $crNewSubs->add(new \Criteria('status', Constants::SUBMISSION_NEW));
        $ret['new_subs'] = $submissionsHandler->getCount($crNewSubs);
        // get truncated description
        $ret['description_short'] = \XoopsModules\Xcontact\Utility::truncateHtml($ret['description'], $truncateLength);
        // misc
        $ret['tpl_tag'] = '{xcontact slug="' . $ret['slug'] . '"}';
        $ret['url']     = \XOOPS_URL . '/modules/xcontact/form.php?slug=' . urlencode($ret['slug']);

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
