<?php declare(strict_types=1);

namespace XoopsModules\Xcontact\Common;

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
 * @license      GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @copyright    https://xoops.org 2000-2020 &copy; XOOPS Project
 * @author       ZySpec <zyspec@yahoo.com>
 * @author       Mamba <mambax7@gmail.com>
 */

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Xcontact\Helper;

/**
 * Class SysUtility
 */
class SysUtility
{
    use VersionChecks;

    //checkVerXoops, checkVerPhp Traits

    use ServerStats;

    // getServerStats Trait

    use FilesManagement;

    // Files Management Trait

    //--------------- Common module methods -----------------------------

    /**
     * Access the only instance of this class
     *
     * @return object
     */
    public static function getInstance()
    {
        static $instance;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * @param             $text
     * @param             $form_sort
     * @param Helper|null $helper
     */
    public static function selectSorting($text, $form_sort, $helper = null): string
    {
        global $start, $order, $file_cat, $sort, $xoopsModule;

        $select_view   = '';
        $moduleDirName = \basename(\dirname(__DIR__));
        /** @var Helper $helper */
        if (null === $helper) {
            $helper = Helper::getInstance();
        }

        //$pathModIcon16 = XOOPS_URL . '/modules/' . $moduleDirName . '/' . $helper->getConfig('modicons16');
        $pathModIcon16 = $helper->url($helper->getModule()->getInfo('modicons16'));
        //        $pathIcon16 = Admin::iconUrl('', '16');

        $select_view = '<form name="form_switch" id="form_switch" action="' . Request::getString('REQUEST_URI', '', 'SERVER') . '" method="post"><span style="font-weight: bold;">' . $text . '</span>';
        //$sorts =  $sort ==  'asc' ? 'desc' : 'asc';
        if ($form_sort == $sort) {
            $sel1 = 'asc' === $order ? 'selasc.png' : 'asc.png';
            $sel2 = 'desc' === $order ? 'seldesc.png' : 'desc.png';
        } else {
            $sel1 = 'asc.png';
            $sel2 = 'desc.png';
        }
        $select_view .= '  <a href="' . Request::getString('SCRIPT_NAME', '', 'SERVER') . '?start=' . $start . '&sort=' . $form_sort . '&order=asc"><img src="' . $pathModIcon16 . '/' . $sel1 . '" title="ASC" alt="ASC"></a>';
        $select_view .= '<a href="' . Request::getString('SCRIPT_NAME', '', 'SERVER') . '?start=' . $start . '&sort=' . $form_sort . '&order=desc"><img src="' . $pathModIcon16 . '/' . $sel2 . '" title="DESC" alt="DESC"></a>';
        $select_view .= '</form>';

        return $select_view;
    }

    /***************Blocks***************/

    /**
     * @param array $cats
     */
    public static function blockAddCatSelect($cats): string
    {
        $cat_sql = '';
        if (\is_array($cats) && !empty($cats)) {
            $cat_sql = '(' . \current($cats);
            \array_shift($cats);
            foreach ($cats as $cat) {
                $cat_sql .= ',' . $cat;
            }
            $cat_sql .= ')';
        }

        return $cat_sql;
    }

    /**
     * @param $content
     */
    public static function metaKeywords($content): void
    {
        global $xoopsTpl, $xoTheme;
        $myts    = \MyTextSanitizer::getInstance();
        $content = $myts->undoHtmlSpecialChars($myts->displayTarea($content));
        if (null !== $xoTheme && \is_object($xoTheme)) {
            $xoTheme->addMeta('meta', 'keywords', \strip_tags($content));
        } else {    // Compatibility for old Xoops versions
            $xoopsTpl->assign('xoops_metaKeywords', \strip_tags($content));
        }
    }

    /**
     * @param $content
     */
    public static function metaDescription($content): void
    {
        global $xoopsTpl, $xoTheme;
        $myts    = \MyTextSanitizer::getInstance();
        $content = $myts->undoHtmlSpecialChars($myts->displayTarea($content));
        if (null !== $xoTheme && \is_object($xoTheme)) {
            $xoTheme->addMeta('meta', 'description', \strip_tags($content));
        } else {    // Compatibility for old Xoops versions
            $xoopsTpl->assign('xoops_metaDescription', \strip_tags($content));
        }
    }

    /**
     * @param $tableName
     * @param $columnName
     */
    public static function enumerate($tableName, $columnName): array
    {
        $table = $GLOBALS['xoopsDB']->prefix($tableName);

        //    $result = $GLOBALS['xoopsDB']->query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
        //        WHERE TABLE_NAME = '" . $table . "' AND COLUMN_NAME = '" . $columnName . "'")
        //    || exit ($GLOBALS['xoopsDB']->error());

        $sql    = 'SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "' . $table . '" AND COLUMN_NAME = "' . $columnName . '"';
        $result = $GLOBALS['xoopsDB']->query($sql);
        if (!$GLOBALS['xoopsDB']->isResultSet($result) || !($result instanceof \mysqli_result)) {
            \trigger_error(\sprintf(\_DB_QUERY_ERROR, $sql) . $GLOBALS['xoopsDB']->error(), \E_USER_ERROR);
        }

        $row = (($GLOBALS['xoopsDB']->isResultSet($result) && ($result instanceof \mysqli_result)) ? $GLOBALS['xoopsDB']->fetchBoth($result) : false);
        if (false === $row) {
            return [];
        }
        $enumList = \explode(',', \str_replace("'", '', \mb_substr($row['COLUMN_TYPE'], 5, -6)));

        return $enumList;
    }

    /**
     * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
     * www.gsdesign.ro/blog/cut-html-string-without-breaking-the-tags
     * www.cakephp.org
     *
     * @param string $text         String to truncate.
     * @param int    $length       Length of returned string, including ellipsis.
     * @param string $ending       Ending to be appended to the trimmed string.
     * @param bool   $exact        If false, $text will not be cut mid-word
     * @param bool   $considerHtml If true, HTML tags would be handled correctly
     *
     * @return string Trimmed string.
     */
    public static function truncateHtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true): string
    {
        $openTags = [];
        if ($considerHtml) {
            // if the plain text is shorter than the maximum length, return the whole text
            if (mb_strlen(\preg_replace('/<.*?' . '>/', '', $text)) <= $length) {
                return $text;
            }
            // splits all html-tags to scanable lines
            \preg_match_all('/(<.+?' . '>)?([^<>]*)/s', $text, $lines, \PREG_SET_ORDER);
            $total_length = mb_strlen($ending);
            $openTags     = [];
            $truncate     = '';
            foreach ($lines as $lineMatchings) {
                // if there is any html-tag in this line, handle it and add it (uncounted) to the output
                if (!empty($lineMatchings[1])) {
                    // if it's an "empty element" with or without xhtml-conform closing slash
                    if (\preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $lineMatchings[1])) {
                        // do nothing
                        // if tag is a closing tag
                    } elseif (\preg_match('/^<\s*\/(\S+?)\s*>$/s', $lineMatchings[1], $tag_matchings)) {
                        // delete tag from $openTags list
                        $pos = \array_search($tag_matchings[1], $openTags, true);
                        if (false !== $pos) {
                            unset($openTags[$pos]);
                        }
                        // if tag is an opening tag
                    } elseif (\preg_match('/^<\s*([^\s>!]+).*?' . '>$/s', $lineMatchings[1], $tag_matchings)) {
                        // add tag to the beginning of $openTags list
                        \array_unshift($openTags, \mb_strtolower($tag_matchings[1]));
                    }
                    // add html-tag to $truncate'd text
                    $truncate .= $lineMatchings[1];
                }
                // calculate the length of the plain text part of the line; handle entities as one character
                $content_length = mb_strlen(\preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $lineMatchings[2]));
                if ($total_length + $content_length > $length) {
                    // the number of characters which are left
                    $left            = $length - $total_length;
                    $entities_length = 0;
                    // search for html entities
                    if (\preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $lineMatchings[2], $entities, \PREG_OFFSET_CAPTURE)) {
                        // calculate the real length of all entities in the legal range
                        foreach ($entities[0] as $entity) {
                            if ($left >= $entity[1] + 1 - $entities_length) {
                                $left--;
                                $entities_length += mb_strlen($entity[0]);
                            } else {
                                // no more characters left
                                break;
                            }
                        }
                    }
                    $truncate .= mb_substr($lineMatchings[2], 0, $left + $entities_length);
                    // maximum lenght is reached, so get off the loop
                    break;
                }
                $truncate     .= $lineMatchings[2];
                $total_length += $content_length;

                // if the maximum length is reached, get off the loop
                if ($total_length >= $length) {
                    break;
                }
            }
        } else {
            if (mb_strlen($text) <= $length) {
                return $text;
            }
            $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
        }
        // if the words shouldn't be cut in the middle...
        if (!$exact) {
            // ...search the last occurance of a space...
            $spacepos = mb_strrpos($truncate, ' ');
            if (false !== $spacepos) {
                // ...and cut the text in this position
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }
        // add the defined ending to the text
        $truncate .= $ending;
        if ($considerHtml) {
            // close all unclosed html-tags
            foreach ($openTags as $tag) {
                $truncate .= '</' . $tag . '>';
            }
        }

        return $truncate;
    }

    /**
     * @param \Xmf\Module\Helper $helper
     * @param array|null         $options
     * @return \XoopsFormDhtmlTextArea|\XoopsFormEditor
     */
    public static function getEditor($helper = null, $options = null)
    {
        /** @var Helper $helper */
        if (null === $options) {
            $options           = [];
            $options['name']   = 'Editor';
            $options['value']  = 'Editor';
            $options['rows']   = 10;
            $options['cols']   = '100%';
            $options['width']  = '100%';
            $options['height'] = '400px';
        }

        if (null === $helper) {
            $helper = Helper::getInstance();
        }

        $isAdmin = $helper->isUserAdmin();

        if (\class_exists('XoopsFormEditor')) {
            if ($isAdmin) {
                $descEditor = new \XoopsFormEditor(\ucfirst($options['name']), $helper->getConfig('editorAdmin'), $options, $nohtml = false, $onfailure = 'textarea');
            } else {
                $descEditor = new \XoopsFormEditor(\ucfirst($options['name']), $helper->getConfig('editorUser'), $options, $nohtml = false, $onfailure = 'textarea');
            }
        } else {
            $descEditor = new \XoopsFormDhtmlTextArea(\ucfirst($options['name']), $options['name'], $options['value'], '100%', '100%');
        }

        //        $form->addElement($descEditor);

        return $descEditor;
    }

    /**
     * @param $fieldname
     * @param $table
     */
    public static function fieldExists(string $fieldname, string $table): bool
    {
        global $xoopsDB;
        if (!preg_match('/^[A-Za-z0-9_]+$/', $fieldname) || !preg_match('/^[A-Za-z0-9_`]+$/', $table)) {
            return false;
        }

        $sql    = 'SHOW COLUMNS FROM ' . $table . ' LIKE ' . $xoopsDB->quote($fieldname);
        $result = self::queryAndCheck($xoopsDB, $sql);

        return ((($xoopsDB->isResultSet($result) && ($result instanceof \mysqli_result)) ? $xoopsDB->getRowsNum($result) : 0) > 0);
    }

    /**
     * @param array|string $tableName
     * @param string       $id_field
     * @param int          $id
     *
     * @return mixed
     */
    public static function cloneRecord($tableName, $id_field, $id)
    {
        $new_id = false;
        if (!preg_match('/^[A-Za-z0-9_]+$/', (string)$tableName)
            || !preg_match('/^[A-Za-z0-9_]+$/', (string)$id_field)) {
            return false;
        }

        $table  = $GLOBALS['xoopsDB']->prefix($tableName);
        // copy content of the record you wish to clone
        $sql    = "SELECT * FROM $table WHERE `$id_field`=" . $GLOBALS['xoopsDB']->quote((string)$id);
        $tempTable = null;
        $result    = $GLOBALS['xoopsDB']->query($sql);
        if ($GLOBALS['xoopsDB']->isResultSet($result) && $result instanceof \mysqli_result) {
            $tempTable = (($GLOBALS['xoopsDB']->isResultSet($result) && ($result instanceof \mysqli_result)) ? $GLOBALS['xoopsDB']->fetchArray($result, \MYSQLI_ASSOC) : false);
        }
        if (!$tempTable) {
            \trigger_error($GLOBALS['xoopsDB']->error());
        }
        // set the auto-incremented id's value to blank.
        unset($tempTable[$id_field]);
        // insert cloned copy of the original  record
        $columns = array_map(static fn ($column): string => '`' . str_replace('`', '``', (string)$column) . '`', array_keys($tempTable));
        $values  = array_map(static fn ($value): string => $GLOBALS['xoopsDB']->quote((string)$value), array_values($tempTable));
        $sql     = "INSERT INTO $table (" . \implode(', ', $columns) . ') VALUES (' . \implode(', ', $values) . ')';
        $result  = $GLOBALS['xoopsDB']->exec($sql);
        if (!$result) {
            \trigger_error(\sprintf(\_DB_QUERY_ERROR, $sql) . $GLOBALS['xoopsDB']->error(), \E_USER_ERROR);

        }
        // Return the new id
        $new_id = $GLOBALS['xoopsDB']->getInsertId();

        return $new_id;
    }

    /**
     * Function responsible for checking if a directory exists, we can also write in and create an index.html file
     *
     * @param string $folder The full path of the directory to check
     */
    public static function prepareFolder($folder): void
    {
        if (!self::isSafeFilesystemPath((string)$folder)) {
            throw new \RuntimeException(\sprintf('Refusing unsafe directory path: %s', $folder));
        }

        if (!\is_dir($folder) && !@\mkdir($folder, 0755, true) && !\is_dir($folder)) {
            throw new \RuntimeException(\sprintf('Unable to create the %s directory', $folder));
        }

        $indexFile = rtrim((string)$folder, '/\\') . '/index.html';
        if (!is_file($indexFile)) {
            file_put_contents($indexFile, '<script>history.go(-1);</script>');
        }
    }

    /**
     * Check if dB table exists
     *
     * @param string $tablename dB tablename with prefix
     * @return bool true if table exists
     */
    public static function tableExists(string $tablename): bool
    {
        $ret    = false;
        $trace = \debug_backtrace(\DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        \trigger_error(__FUNCTION__ . " is deprecated, called from {$trace[0]['file']} line {$trace[0]['line']}");
        $GLOBALS['xoopsLogger']->addDeprecated(
            \basename(\dirname(__DIR__, 2)) . ' Module: ' . __FUNCTION__ . ' function is deprecated, please use Xmf\Database\Tables method(s) instead.' . " Called from {$trace[0]['file']}line {$trace[0]['line']}"
        );
        $sql    = 'SHOW TABLES LIKE ' . $GLOBALS['xoopsDB']->quote($tablename);
        $result = self::queryAndCheck($GLOBALS['xoopsDB'], $sql);

        return $GLOBALS['xoopsDB']->isResultSet($result) && ($result instanceof \mysqli_result) && $GLOBALS['xoopsDB']->getRowsNum($result) > 0;
    }

    /**
     * Query and check if the result is a valid result set
     *
     * @param \XoopsMySQLDatabase $xoopsDB XOOPS Database
     * @param string              $sql     a valid MySQL query
     * @param int                 $limit   number of records to return
     * @param int                 $start   offset of first record to return
     *
     * @return \mysqli_result query result
     */
    public static function queryAndCheck(\XoopsMySQLDatabase $xoopsDB, string $sql, $limit = 0, $start = 0): \mysqli_result
    {
        $result = $xoopsDB->query($sql, $limit, $start);

        if (!$xoopsDB->isResultSet($result) || !($result instanceof \mysqli_result)) {
            throw new \RuntimeException(
                \sprintf(\_DB_QUERY_ERROR, $sql) . $xoopsDB->error(), \E_USER_ERROR);
        }

        return $result;
    }

    /**
     * QueryF and check if the result is a valid result set
     *
     * @param \XoopsMySQLDatabase $xoopsDB XOOPS Database
     * @param string              $sql     a valid MySQL query
     * @param int                 $limit   number of records to return
     * @param int                 $start   offset of first record to return
     *
     * @return \mysqli_result query result
     */
    public static function queryFAndCheck(\XoopsMySQLDatabase $xoopsDB, string $sql, $limit = 0, $start = 0): \mysqli_result
    {
        return self::queryAndCheck($xoopsDB, $sql, $limit, $start);
    }

}
