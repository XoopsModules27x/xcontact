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

use Xmf\Request;
use XoopsModules\Xcontact;


/**
 * Class Object Handler Submissions
 */
class SubmissionsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'xcontact_submissions', Submissions::class, 'sub_id', 'form_id');
    }

    /**
     * @param bool $isNew
     *
     * @return object
     */
    public function create($isNew = true)
    {
        return parent::create($isNew);
    }

    /**
     * retrieve a field
     *
     * @param int $id field id
     * @param null fields
     * @return \XoopsObject|null reference to the {@link Get} object
     */
    public function get($id = null, $fields = null)
    {
        return parent::get($id, $fields);
    }

    /**
     * get inserted id
     *
     * @return int reference to the {@link Get} object
     */
    public function getInsertId()
    {
        return $this->db->getInsertId();
    }

    /**
     * Get Count Submissions in the database
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountSubmissions($sort = 'sub_id ASC, form_id', $order = 'ASC')
    {
        $crCountSubmissions = new \CriteriaCompo();
        $crCountSubmissions = $this->getSubmissionsCriteria($crCountSubmissions, 0, 0, $sort, $order);
        return $this->getCount($crCountSubmissions);
    }

    /**
     * Get All Submissions in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllSubmissions($start = 0, $limit = 0, $sort = 'sub_id ASC, form_id', $order = 'ASC')
    {
        $crAllSubmissions = new \CriteriaCompo();
        $crAllSubmissions = $this->getSubmissionsCriteria($crAllSubmissions, $start, $limit, $sort, $order);
        return $this->getAll($crAllSubmissions);
    }

    /**
     * Get Criteria Submissions
     * @param        $crSubmissions
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return \CriteriaCompo
     */
    private function getSubmissionsCriteria($crSubmissions, $start, $limit, $sort, $order)
    {
        if ($limit > 0) {
            $crSubmissions->setStart($start);
            $crSubmissions->setLimit($limit);
        }
        $crSubmissions->setSort($sort);
        $crSubmissions->setOrder($order);
        return $crSubmissions;
    }

    /**
     * get inserted id
     *
     * @return int reference to the {@link Get} object
     */
    public function processSubmission($cf_fields, $cf_settings, $cf_form)
    {
        $helper  = Helper::getInstance();

        $cf_form_id = $cf_form['form_id'];
        $cf_success  = false;
        $cf_errors   = [];
        $cf_data     = [];

        // preferences for uploading files
        $allowed = $helper->getConfig('upload_filetypes');
        $cf_fileupload_types = _MD_XCONTACT_FORM_UPLOAD_FILETYPE . implode(', ', $allowed);

        $uploadMaxSize = (int)$helper->getConfig('upload_max_size');
        $cf_fileupload_size = \_MD_XCONTACT_FORM_UPLOAD_SIZE . ($uploadMaxSize / 1048576) . ' ' . \_MD_XCONTACT_FORM_UPLOAD_SIZE_MB;

        // Honeypot
        if ('' !== Request::getString('cf_hp', '', 'POST')) {
            $cf_success = true;
        }

        // Captcha
        if (!$cf_success && !empty($cf_settings['enable_captcha'])) {
            if (!xcontact_verify_captcha($_POST['cf_captcha'] ?? '')) {
                $cf_errors[] = _MD_XCONTACT_CAPTCHA_ERROR;
            }
        }

        if (!$cf_success && empty($cf_errors)) {
            foreach ($cf_fields as $field) {
                $fn = $field['name'] ?? '';
                $ftype = $field['type'] ?? '';
                $req = !empty($field['required']);
                if (!$fn || in_array($ftype, ['label', 'heading', 'paragraph'])) continue;

                if ($ftype === 'choice') {
                    $val = Request::hasVar($fn, 'POST') ? array_map('strip_tags', Request::getArray($fn, [], 'POST')) : [];
                    if ($req && empty($val)) $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_REQUIRED;
                } elseif ($ftype === 'file') {
                    // TODO: replace by XoopsMediaUploader
                    $val = '';
                    if (isset($_FILES[$fn]) && $_FILES[$fn]['error'] === UPLOAD_ERR_OK) {
                        $ext = strtolower(pathinfo($_FILES[$fn]['name'], PATHINFO_EXTENSION));
                        if (!in_array($ext, $allowed)) {
                            $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ': ' . _MD_XCONTACT_INVALID_EXT;
                        } elseif ($_FILES[$fn]['size'] > $uploadMaxSize) {
                            $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ': ' . _MD_XCONTACT_FILE_TOO_BIG;
                        } else {
                            xcontact_ensure_upload_dir();
                            $udir = XOOPS_UPLOAD_PATH . '/xcontact/';
                            $safe = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $_FILES[$fn]['name']);
                            if (@move_uploaded_file($_FILES[$fn]['tmp_name'], $udir . $safe)) {
                                $val = XOOPS_UPLOAD_URL . '/xcontact/' . $safe;
                            }
                        }
                    } elseif ($req) {
                        $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_REQUIRED;
                    }
                } elseif ($ftype === 'consent') {
                    $val = Request::getInt($fn, 0, 'POST');
                    if ($req && 1 !== $val) $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_MUST_ACCEPT;
                } else {
                    $raw = Request::getString($fn, '', 'POST');
                    if ($raw === '' && isset($field['value'])) {
                        $raw = (string)$field['value'];
                    }
                    $val = strip_tags(trim($raw));
                    if ($req && $val === '') $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_REQUIRED;
                    if ($val !== '') {
                        if ($ftype === 'email' && !filter_var($val, FILTER_VALIDATE_EMAIL)) $cf_errors[] = _MD_XCONTACT_INVALID_EMAIL;
                        if ($ftype === 'number' && !is_numeric($val)) $cf_errors[] = htmlspecialchars($field['label'] ?? $fn) . ' ' . _MD_XCONTACT_MUST_BE_NUMBER;
                    }
                }
                $cf_data[$fn] = $val;
            }

            if (empty($cf_errors)) {
                $submissionsObj = $this->create();
                $submissionsObj->setVar('form_id', $cf_form_id);
                $submissionsObj->setVar('data', json_encode($cf_data, JSON_UNESCAPED_UNICODE));
                $submissionsObj->setVar('ip', $_SERVER['REMOTE_ADDR']);
                $submissionsObj->setVar('status', 0);
                $submissionsObj->setVar('created_at', time());
                // Insert Data
                if ($this->insert($submissionsObj)) {
                    // send mail depending on setings of 'notify_email'
                    if (!empty($cf_settings['notify_email'])) {
                        $body = \_AM_XCONTACT_FORM . ':' . $cf_form['name'] . "\n" . _MD_XCONTACT_SUB_DATE_LABEL . ': ' . date('d.m.Y H:i') . "\nIP: {$_SERVER['REMOTE_ADDR']}\n" . str_repeat('-', 40) . "\n";
                        foreach ($cf_data as $k => $v) {
                            $lbl = $k;
                            foreach ($cf_fields as $fd) {
                                if (($fd['name'] ?? '') === $k) {
                                    $lbl = $fd['label'] ?? $k;
                                    break;
                                }
                            }
                            $body .= $lbl . ': ' . (is_array($v) ? implode(', ', $v) : $v) . "\n";
                        }
                        xcontact_send_mail($cf_settings['notify_email'], $cf_settings['email_subject'] ?? _MD_XCONTACT_NEW_SUBMISSION, $body);
                    }
                    $cf_success = true;
                } else {
                    // redirect after error when inserting
                    $cf_errors[] = \_MD_XCONTACT_SUBMISSION_ERROR;
                    //\redirect_header('index.php?op=list', 5, \_MD_XCONTACT_SUBMISSION_ERROR);

                }
            }
        }
        return ['success' => $cf_success, 'errors' => $cf_errors];
    }
}
