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
 * Class FileChecker
 * check status of a directory
 */
class FileChecker
{
    /**
     * @param string      $file_path
     * @param string|null $original_file_path
     * @param string|null $redirectFile
     * @return bool|string
     */
    public static function getFileStatus($file_path, $original_file_path = null, $redirectFile = null)
    {
        global $pathIcon16;

        if (empty($file_path)) {
            return false;
        }
        $filePath = self::escape((string)$file_path);

        if (null === $original_file_path) {
            if (self::fileExists($file_path)) {
                $path_status = "<img src='$pathIcon16/1.png' >";
                $path_status .= "$filePath (" . self::message('FC_AVAILABLE', 'available') . ') ';
            } else {
                $path_status = "<img src='$pathIcon16/0.png' >";
                $path_status .= "$filePath (" . self::message('FC_NOTAVAILABLE', 'not available') . ') ';
            }
        } else {
            if (self::compareFiles($file_path, $original_file_path)) {
                $path_status = "<img src='$pathIcon16/1.png' >";
                $path_status .= "$filePath (" . self::message('FC_AVAILABLE', 'available') . ') ';
            } else {
                $path_status = "<img src='$pathIcon16/0.png' >";
                $path_status .= "$filePath (" . self::message('FC_NOTAVAILABLE', 'not available') . ') ';
            }
        }

        return $path_status;
    }

    /**
     * @param   $source_path
     * @param   $destination_path
     */
    public static function copyFile($source_path, $destination_path, ?string $allowedBasePath = null): bool
    {
        if (!self::isAllowedPath((string)$source_path, $allowedBasePath)
            || !self::isAllowedPath((string)$destination_path, $allowedBasePath)) {
            return false;
        }

        return @\copy($source_path, $destination_path);
    }

    /**
     * @param   $file1_path
     * @param   $file2_path
     */
    public static function compareFiles($file1_path, $file2_path): bool
    {
        if (!self::fileExists($file1_path) || !self::fileExists($file2_path)) {
            return false;
        }
        if (\filetype($file1_path) !== \filetype($file2_path)) {
            return false;
        }
        if (\filesize($file1_path) !== \filesize($file2_path)) {
            return false;
        }

        $crc1 = \hash_file('crc32b', $file1_path);
        $crc2 = \hash_file('crc32b', $file2_path);

        return false !== $crc1 && false !== $crc2 && $crc1 === $crc2;
    }

    /**
     * @param   $file_path
     */
    public static function fileExists($file_path): bool
    {
        return \is_file($file_path);
    }

    /**
     * @param     $target
     * @param int $mode
     */
    public static function setFilePermissions($target, $mode = 0644, ?string $allowedBasePath = null): bool
    {
        if (!self::isAllowedPath((string)$target, $allowedBasePath)) {
            return false;
        }

        return @\chmod($target, self::normalizeMode($mode, 0644));
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
