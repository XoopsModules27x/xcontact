<?php declare(strict_types=1);
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project (https://xoops.org)
 * @license      GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author       XOOPS Development Team
 * @param mixed $val
 */

/**
 * @param $val
 * @return float
 */

function xcontactReturnBytes($val): float
{
    if (\is_int($val) || \is_float($val)) {
        return (float)$val;
    }
    if (!\is_string($val)) {
        throw new \InvalidArgumentException('Expected numeric string or number.');
    }

    $val = \trim($val);
    $unit = \strtolower(\substr($val, -1));
    $number = (float)$val;

    return match ($unit) {
        'k' => $number * 1024,
        'm' => $number * 1048576,
        'g' => $number * 1073741824,
        default => $number,
    };
 }
