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
 * Configurator Class
 *
 * @copyright   2000-2026 XOOPS Project (https://xoops.org)
 * @license     GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author      XOOPS Development Team
 */

// require_once \dirname(__DIR__, 2) . '/include/common.php';

/**
 * Class Configurator
 */
class Configurator
{
    public string $name;
    /** @var array<string, mixed> */
    public array $paths = [];
    /** @var list<string> */
    public array $uploadFolders = [];
    /** @var list<string> */
    public array $copyBlankFiles = [];
    /** @var list<array{0: string, 1: string}> */
    public array $copyTestFolders = [];
    /** @var list<string> */
    public array $templateFolders = [];
    /** @var list<string> */
    public array $oldFiles = [];
    /** @var list<string> */
    public array $oldFolders = [];
    /** @var array<string, string> */
    public array $renameTables = [];
    /** @var array<string, mixed> */
    public array $renameColumns = [];
    /** @var array<string, mixed> */
    public array $moduleStats = [];
    public string $modCopyright;
    /** @var array<string, mixed> */
    public array $icons = [];
    private string $baseDir;

    /**
     * Configurator constructor.
     * @param $dir
     */
    public function __construct($dir = null)
    {
        $dir = rtrim((string)$dir, '/\\');
        $resolvedBaseDir = '' !== $dir ? $dir : \dirname(__DIR__, 2);
        $this->baseDir = $resolvedBaseDir;

        $configFile = $this->baseDir . '/config/config.php';
        if (!\is_file($configFile)) {
            throw new \RuntimeException('Missing config file: ' . $configFile);
        }
        $config = require $configFile;
        if (!\is_object($config)) {
            throw new \RuntimeException(
                \sprintf(
                    'Invalid config format in %s: expected object, got %s',
                    $configFile,
                    \gettype($config)
                )
            );
        }


        $this->name            = (string)$config->name;
        // $this->paths           = $config->paths;
        $this->uploadFolders   = (array)$config->uploadFolders;
        $this->copyBlankFiles  = (array)$config->copyBlankFiles;
        $this->copyTestFolders = (array)$config->copyTestFolders;
        $this->templateFolders = (array)$config->templateFolders;
        $this->oldFiles        = (array)$config->oldFiles;
        $this->oldFolders      = (array)$config->oldFolders;
        $this->renameTables    = (array)$config->renameTables;
        $this->renameColumns   = (array)$config->renameColumns;
        $this->moduleStats     = (array)$config->moduleStats;
        $this->modCopyright    = (string)$config->modCopyright;

        $iconsFile = $this->baseDir . '/config/icons.php';
        $pathsFile = $this->baseDir . '/config/paths.php';
        if (!\is_file($iconsFile)) {
            throw new \RuntimeException('Missing icons config file: ' . $iconsFile);
        }
        if (!\is_file($pathsFile)) {
            throw new \RuntimeException('Missing paths config file: ' . $pathsFile);
        }
        $this->icons = (array)require $iconsFile;
        $this->paths = (array)require $pathsFile;
    }

    public function getPath(string $key): ?string
    {
        $value = $this->paths[$key] ?? null;

        return is_string($value) ? $value : null;
    }

    public function baseDir(): string
    {
        return $this->baseDir;
    }
}
