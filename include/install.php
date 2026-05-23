<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

$db        = XoopsDatabaseFactory::getDatabaseConnection();
$tblBlocks = $db->prefix('newblocks');
$tblFile   = $db->prefix('tplfile');
$tblSource = $db->prefix('tplsource');

// 1. Upload klasörü
$uploadDir = XOOPS_ROOT_PATH . '/uploads/xcontact';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
    file_put_contents($uploadDir . '/index.html', '<html><body></body></html>');
}

// 2. newblocks kaydını düzelt
$db->queryF("UPDATE `{$tblBlocks}` SET
    func_file = 'xcontact_blocks.php',
    show_func = 'xcontact_block_form',
    edit_func = 'xcontact_block_form_edit',
    template  = 'xcontact_block_form.tpl'
    WHERE dirname = 'xcontact'"
);

// 3. tplfile: prefix'siz, type=block
$db->queryF("UPDATE `{$tblFile}` SET
    tpl_file = 'xcontact_block_form.tpl',
    tpl_type = 'block'
    WHERE tpl_module = 'xcontact'
    AND tpl_file IN ('blocks/xcontact_block_form.tpl','xcontact_block_form.tpl')"
);

// 4. tplsource: fiziksel dosyadan güncelle
$tplPath = XOOPS_ROOT_PATH . '/modules/xcontact/templates/blocks/xcontact_block_form.tpl';
if (file_exists($tplPath)) {
    $src = $db->escape(file_get_contents($tplPath));
    $now = time();
    $res = $db->query("SELECT tpl_id FROM `{$tblFile}` WHERE tpl_module='xcontact' AND tpl_file='xcontact_block_form.tpl' ORDER BY tpl_id ASC LIMIT 1");
    if ($res && ($row = $db->fetchArray($res))) {
        $tid = (int)$row['tpl_id'];
        $sc  = $db->query("SELECT tpl_id FROM `{$tblSource}` WHERE tpl_id='{$tid}' LIMIT 1");
        if ($sc && $db->getRowsNum($sc) > 0) {
            $db->queryF("UPDATE `{$tblSource}` SET tpl_source='{$src}' WHERE tpl_id='{$tid}'");
        } else {
            $db->queryF("INSERT INTO `{$tblSource}` (tpl_id,tpl_source) VALUES ('{$tid}','{$src}')");
        }
        $db->queryF("UPDATE `{$tblFile}` SET tpl_lastmodified='{$now}' WHERE tpl_id='{$tid}'");
    }
}

// 5. Smarty compile cache temizle
foreach ([
    XOOPS_ROOT_PATH . '/../xoops_data/caches/smarty_compile',
    XOOPS_ROOT_PATH . '/xoops_data/caches/smarty_compile',
] as $dir) {
    if (!is_dir($dir)) continue;
    foreach (new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    ) as $f) {
        if ($f->isFile() && $f->getExtension() === 'php') @unlink($f->getPathname());
    }
}
