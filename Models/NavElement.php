<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\Navigation\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Navigation\Models;

/**
 * Navigation element class.
 *
 * @package Modules\Navigation\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class NavElement
{
    /**
     * Id.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    /**
     * Page Id.
     *
     * Generated from the path from a URI (sha1)
     *
     * @var string
     * @since 1.0.0
     */
    public string $pid = '';

    /**
     * Name of the link.
     *
     * This "name" is a identifier for which is used in the language file for localization.
     *
     * @var string
     * @since 1.0.0
     */
    public string $name = '';

    /**
     * Link type.
     *
     * @var int
     * @since 1.0.0
     */
    public int $type = LinkType::LINK;

    /**
     * Navigation type (location of the link)
     *
     * @var int
     * @since 1.0.0
     */
    public int $subtype = NavigationType::SIDE;

    /**
     * Icon string (css string for icon).
     *
     * @var null|string
     * @since 1.0.0
     */
    public ?string $icon = null;

    /**
     * Uri.
     *
     * @var null|string
     * @since 1.0.0
     */
    public ?string $uri = null;

    /**
     * Link target (target="self").
     *
     * @var string
     * @since 1.0.0
     */
    public string $target = 'self';

    /**
     * Action to perform on click.
     *
     * @var null|string
     * @since 1.0.0
     */
    public ?string $action = null;

    /**
     * Module identifier.
     *
     * @var string
     * @since 1.0.0
     */
    public string $from = '0';

    /**
     * Order.
     *
     * @var int
     * @since 1.0.0
     */
    public int $order = 1;

    /**
     * Parent navigation element.
     *
     * @var int
     * @since 1.0.0
     */
    public int $parent = 0;

    /**
     * User permission required to show link (null = always/any).
     *
     * @var null|int
     * @since 1.0.0
     */
    public ?int $permissionPerm = null;

    /**
     * Permission type required to show link (null = any).
     *
     * Modules have different permission types (e.g. customer).
     * The available types are defind in the respective module in \Modules\???\Models\PermissionState
     *
     * @var null|int
     * @since 1.0.0
     */
    public ?int $permissionType = null;

    /**
     * Element these permissions must be valid for (null = any).
     *
     * @var null|int
     * @since 1.0.0
     */
    public ?int $permissionElement = null;
}
