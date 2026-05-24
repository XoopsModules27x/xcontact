<?php declare(strict_types=1);

namespace XoopsModules\Xcontact\Common;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * Xcontact module
 *
 * @copyright       2000-2026 XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Xoops Development Team
 */

/**
 * Class DirectoryChecker
 * check status of a directory
 */
class DirectoryChecker
{
    /**
     * @param     $path
     * @param int $mode
     * @param     $redirectFile
     *
     * @return bool|string
     */
    public static function getDirectoryStatus($path, $mode = 0755, $redirectFile = null)
    {
        $pathIcon16 = \Xmf\Module\Admin::iconUrl('', '16');

        if (empty($path)) {
            return false;
        }
        $displayPath = self::escape((string)$path);

        if (!@\is_dir($path)) {
            $path_status = "<img src='$pathIcon16/0.png' >";
            $path_status .= "$displayPath (" . self::message('DC_NOTAVAILABLE', 'not available') . ') ';
        } elseif (@\is_writable($path)) {
            $path_status = "<img src='$pathIcon16/1.png' >";
            $path_status .= "$displayPath (" . self::message('DC_AVAILABLE', 'available') . ') ';
            $currentMode = mb_substr(\decoct(\fileperms($path)), 2);
            if ($currentMode != \decoct($mode)) {
                $path_status = "<img src='$pathIcon16/0.png' >";
                $path_status .= $displayPath . sprintf(
                    self::message('DC_NOTWRITABLE', ' should be writable as %s; current mode is %s'),
                    \decoct($mode),
                    $currentMode
                );
            }
        } else {
            $currentMode = mb_substr(\decoct(\fileperms($path)), 2);
            $path_status = "<img src='$pathIcon16/0.png' >";
            $path_status .= $displayPath . sprintf(
                self::message('DC_NOTWRITABLE', ' should be writable as %s; current mode is %s'),
                \decoct($mode),
                $currentMode
            );
        }

        return $path_status;
    }

    /**
     * @param     $target
     * @param int $mode
     */
    public static function createDirectory($target, $mode = 0755, ?string $allowedBasePath = null): bool
    {
        if (!self::isAllowedPath((string)$target, $allowedBasePath)) {
            return false;
        }

        // https://www.php.net/manual/en/function.mkdir.php
        return \is_dir($target)
            || (self::createDirectory(\dirname($target), $mode, $allowedBasePath)
                && (@\mkdir($target, self::normalizeMode($mode, 0755)) || \is_dir($target)));
    }

    /**
     * @param     $target
     * @param int $mode
     */
    public static function setDirectoryPermissions($target, $mode = 0755, ?string $allowedBasePath = null): bool
    {
        if (!self::isAllowedPath((string)$target, $allowedBasePath)) {
            return false;
        }

        return @\chmod($target, self::normalizeMode($mode, 0755));
    }

    /**
     * @param   $dir_path
     */
    public static function dirExists($dir_path): bool
    {
        return \is_dir($dir_path);
    }

    private static function isAllowedPath(string $path, ?string $allowedBasePath): bool
    {
        if ('' === $path || str_contains($path, "\0") || str_contains($path, '://')) {
            return false;
        }

        if (null === $allowedBasePath) {
            return self::isUnderKnownBase($path);
        }

        $base = realpath($allowedBasePath);
        $target = self::resolveExistingPath($path);

        return false !== $base
            && false !== $target
            && self::isContainedPath($target, $base);
    }

    private static function isUnderKnownBase(string $path): bool
    {
        if (str_contains($path, '..')) {
            return false;
        }

        $target = self::resolveExistingPath($path);
        if (false === $target) {
            return false;
        }

        foreach (['XOOPS_ROOT_PATH', 'XOOPS_UPLOAD_PATH'] as $constant) {
            if (!defined($constant)) {
                continue;
            }

            $base = realpath((string)constant($constant));
            if (false !== $base && self::isContainedPath($target, $base)) {
                return true;
            }
        }

        return false;
    }

    private static function isContainedPath(string $target, string $base): bool
    {
        $base = rtrim($base, DIRECTORY_SEPARATOR);

        return $target === $base || str_starts_with($target, $base . DIRECTORY_SEPARATOR);
    }

    private static function resolveExistingPath(string $path): string|false
    {
        $current = $path;
        while ('' !== $current && $current !== \dirname($current)) {
            $resolved = realpath($current);
            if (false !== $resolved) {
                return $resolved;
            }
            $current = \dirname($current);
        }

        return realpath($current);
    }

    private static function normalizeMode($mode, int $fallback): int
    {
        $mode = (int)$mode;
        $allowedModes = [0644, 0664, 0755, 0775];

        return in_array($mode, $allowedModes, true) ? $mode : $fallback;
    }

    private static function message(string $suffix, string $fallback): string
    {
        $constant = 'CO_XCONTACT_' . $suffix;

        return defined($constant) ? (string)constant($constant) : $fallback;
    }

    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
