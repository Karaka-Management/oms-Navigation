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

/**
 * Navigation element class.
 *
 * @package Modules\Navigation\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
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
     * App.
     *
     * @var int
     * @since 1.0.0
     */
    public int $app = 0;

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
     * Page Id.
     *
     * Generated from the path from a URI (sha1)
     *
     * @var string
     * @since 1.0.0
     */
    public string $pidRaw = '';

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
     * Navigation type (location of the link)
     *
     * @var int
     * @since 1.0.0
     */
    public int $type = NavigationType::SIDE;

    /**
     * Link type.
     *
     * @var int
     * @since 1.0.0
     */
    public int $subtype = LinkType::LINK;

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
     * The available categories are defind in the respective module in \Modules\???\Models\PermissionCategory
     *
     * @var null|int
     * @since 1.0.0
     */
    public ?int $permissionCategory = null;

    /**
     * Element these permissions must be valid for (null = any).
     *
     * @var null|int
     * @since 1.0.0
     */
    public ?int $permissionElement = null;

    /**
     * Status.
     *
     * @var int
     * @since 1.0.0
     */
    public int $status = LinkStatus::ACTIVE;
}
