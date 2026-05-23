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
        parent::__construct($db, 'xcontact_submissions', Submissions::class, 'xxx_sub_id', 'xxx_form_id');
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
    public function getCountSubmissions($sort = 'xxx_sub_id ASC, xxx_form_id', $order = 'ASC')
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
    public function getAllSubmissions($start = 0, $limit = 0, $sort = 'xxx_sub_id ASC, xxx_form_id', $order = 'ASC')
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
}
