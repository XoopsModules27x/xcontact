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
 * @author       Goffy (wedega.com)
 */

use XoopsModules\Xcontact\Helper;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

class Icons
{
    private const FONTAWESOME = [
        'plus'   => '<i class="fa-regular fa-square-plus"></i>',
        'list' => '<i class="fa-solid fa-list"></i>',
        'form' => '<i class="fa-brands fa-wpforms"></i>',
        'submission' => '<i class="fa-solid fa-envelope"></i>',
        'back' => '<i class="fa-solid fa-arrow-left"></i>',
        'edit' => '<i class="fa-regular fa-pen-to-square"></i>',
        'delete' => '<i class="fa-regular fa-trash-can"></i>',
        'save' => '<i class="fa-regular fa-floppy-disk"></i>',
        'builder' => '<i class="fa-solid fa-wand-magic-sparkles"></i>',
        'settings' => '<i class="fa-solid fa-gear"></i>',
        'text' => '<i class="fa-solid fa-font"></i>',
        'longtext' => '<i class="fa-solid fa-text-width"></i>',
        'mail' => '<i class="fa-solid fa-at"></i>',
        'website' => '<i class="fa-solid fa-globe"></i>',
        'phone' => '<i class="fa-solid fa-phone-volume"></i>',
        'number' => '<i class="fa-solid fa-hashtag"></i>',
        'date' => '<i class="fa-solid fa-calendar-days"></i>',
        'time' => '<i class="fa-regular fa-clock"></i>',
        'file' => '<i class="fa-regular fa-file"></i>',
        'hidden' => '<i class="fa-solid fa-ban"></i>',
        'label' => '<i class="fa-solid fa-tag"></i>',
        'heading' => '<i class="fa-solid fa-heading"></i>',
        'paragraph' => '<i class="fa-solid fa-paragraph"></i>',
        'choice' => '<i class="fa-regular fa-square-check"></i>',
        'image' => '<i class="fa-regular fa-images"></i>',
        'dropdown' => '<i class="fa-regular fa-square-caret-down"></i>',
        'consent' => '<i class="fa-regular fa-circle-check"></i>',
        'signature' => '<i class="fa-solid fa-signature"></i>',
        'envelope_open' => '<i class="fa-regular fa-envelope-open"></i>'
    ];

    private const UNICODE = [
        'plus'   => '➕',
        'list' => '📋',
        'form' => '🆕',
        'submission' => '📥',
        'back' => '←',
        'edit' => '✏️',
        'delete' => '🗑',
        'save' => '💾',
        'builder' => '🧩',
        'settings' => '⚙️',
        'text' => 'T',
        'longtext' => 'T&#818;',
        'mail' => '@',
        'website' => '🔗',
        'phone' => '📞',
        'number' => '#',
        'date' => '📅',
        'time' => '⏰',
        'file' => '📎',
        'hidden' => '🚫',
        'label' => 'L',
        'heading' => 'H',
        'paragraph' => '¶',
        'choice' => '☑',
        'image' => '🖼',
        'dropdown' => '▼',
        'consent' => '✓',
        'signature' => '✒',
        'envelope_open' => '📧'
    ];

    public static function iconsLoad(): array
    {
        $helper = Helper::getInstance();
        $iconSet = $helper->getConfig('iconset');
        if ('fontawesome' === $iconSet) {
            return self::FONTAWESOME;
        }
        return self::UNICODE;
    }

    public static function get(string $name): string
    {
        $icons = self::iconsLoad();

        return $icons[$name] ?? '';

    }
}
