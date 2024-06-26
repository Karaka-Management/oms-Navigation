<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Navigation\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Navigation\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Navigation type enum.
 *
 * @package Modules\Navigation\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class NavigationType extends Enum
{
    public const TOP = 1;

    public const SIDE = 2;

    public const CONTENT = 3;

    public const TAB = 4;

    public const CONTENT_SIDE = 5;

    public const BOTTOM = 6;
}
