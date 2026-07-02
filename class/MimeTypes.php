<?php declare(strict_types=1);

namespace XoopsModules\Xcontact;

/*
 Utility Class Definition

 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Module:  xcontact
 *
 * @license      https://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       ZySpec <zyspec@yahoo.com>
 * @author       Mamba <mambax7@gmail.com>
 * @since
 */

use XoopsModules\Xcontact;

/**
 * Class MimeTypes
 */
class MimeTypes
{

    /**
     * return a list of possible mimetypes for uplaod
     * used in xoops_version.php and class/Forms.php
     *
     * @return array
     */
    public static function getList()
    {
        $ret = [
            // images
            'gif' => 'image/gif',
            'jpeg' => 'image/jpeg',
            'pjpeg' => 'image/pjpeg',
            'jpg' => 'image/jpg',
            'jpe' => 'image/jpe',
            'png' => 'image/png',
            // documents
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'txt' => 'text/plain',
            // tables
            'xls' => 'application/msexcel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            // misc
            'csv' => 'text/comma-separated-values',
            'zip' => 'application/zip',
        ];

        return $ret;
    }

}
