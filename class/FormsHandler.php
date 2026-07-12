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


/**
 * Class Object Handler Forms
 */
class FormsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'xcontact_forms', Forms::class, 'form_id', 'name');
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
     * Get Count Forms in the database
     * @param string $sort
     * @param string $order
     * @return int
     */
    public function getCountForms($sort = 'form_id ASC, name', $order = 'ASC')
    {
        $crCountForms = new \CriteriaCompo();
        $crCountForms = $this->getFormsCriteria($crCountForms, 0, 0, $sort, $order);
        return $this->getCount($crCountForms);
    }

    /**
     * Get All Forms in the database
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return array
     */
    public function getAllForms($start = 0, $limit = 0, $sort = 'form_id ASC, name', $order = 'ASC')
    {
        $crAllForms = new \CriteriaCompo();
        $crAllForms = $this->getFormsCriteria($crAllForms, $start, $limit, $sort, $order);
        return $this->getAll($crAllForms);
    }

    /**
     * Get Criteria Forms
     * @param        $crForms
     * @param int    $start
     * @param int    $limit
     * @param string $sort
     * @param string $order
     * @return \CriteriaCompo
     */
    private function getFormsCriteria($crForms, $start, $limit, $sort, $order)
    {
        if ($limit > 0) {
            $crForms->setStart($start);
            $crForms->setLimit($limit);
        }
        $crForms->setSort($sort);
        $crForms->setOrder($order);
        return $crForms;
    }

    /**
     * Get Forms by slug, by default only active
     * @param string $slug
     * @param bool   $only_active
     * @return array
     */
    public function getFormBySlug(string $slug, bool $only_active = true)
    {
        // Get active forms
        $crForms = new \CriteriaCompo();
        if ($only_active) {
            $crForms->add(new \Criteria('is_active', Constants::FORM_IS_ACTIVE));
        }
        $crForms->add(new \Criteria('slug', $slug));
        $crForms->setLimit(1);
        $crForms->setSort('form_id');
        $crForms->setOrder('DESC');
        $formsAll = $this->getAll($crForms);
        if (empty($formsAll)) {
            return [];
        }

        return reset($formsAll);
    }

    /**
     * Initiate form fields for first loading
     * @param array $fields
     * @return array
     */
    public function initiateFormFields(array $fields)
    {
        $data = [];
        // initialize all fields with default value
        // all form components (also FormRadio, FormSelect, FormSelectImage) currently expect a single scalar value, unlike choice which is explicitly configured as an array
        foreach ($fields as $f) {
            if ('choice' === $f['type']) {
                $data[$f['name']] = [];
            } else {
                $data[$f['name']] = '';
            }
        }

        return $data;
    }
}
