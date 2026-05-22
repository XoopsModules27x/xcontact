<?php
defined('XOOPS_ROOT_PATH') || exit();
function xoops_module_uninstall_xcform($module = null): bool {
    $dir = XOOPS_UPLOAD_PATH . '/xcform';
    if (is_dir($dir)) {
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($it as $item) { $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname()); }
        @rmdir($dir);
    }
    return true;
}
