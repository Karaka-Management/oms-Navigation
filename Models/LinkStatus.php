<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\Navigation\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\Navigation\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Link status enum.
 *
 * @package Modules\Navigation\Models
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
abstract class LinkStatus extends Enum
{
    public const ACTIVE = 1;

    public const INACTIVE = 2;

    public const HIDDEN = 3;

    public const ANY = 4;
}
