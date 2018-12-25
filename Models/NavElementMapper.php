<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Modules\Navigation
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types=1);

namespace Modules\Navigation\Models;

use phpOMS\DataStorage\Database\DataMapperAbstract;

/**
 * Mapper class.
 *
 * @package    Modules\Navigation
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
final class NavElementMapper extends DataMapperAbstract
{

    /**
     * Columns.
     *
     * @var array<string, array<string, bool|string>>
     * @since 1.0.0
     */
    static protected $columns = [
        'nav_id'                    => ['name' => 'nav_id', 'type' => 'int', 'internal' => 'id'],
        'nav_pid'                   => ['name' => 'nav_pid', 'type' => 'string', 'internal' => 'pid'],
        'nav_name'                  => ['name' => 'nav_name', 'type' => 'string', 'internal' => 'name'],
        'nav_type'                  => ['name' => 'nav_type', 'type' => 'int', 'internal' => 'type'],
        'nav_subtype'               => ['name' => 'nav_subtype', 'type' => 'int', 'internal' => 'subtype'],
        'nav_icon'                  => ['name' => 'nav_icon', 'type' => 'string', 'internal' => 'icon'],
        'nav_uri'                   => ['name' => 'nav_uri', 'type' => 'string', 'internal' => 'uri'],
        'nav_target'                => ['name' => 'nav_target', 'type' => 'string', 'internal' => 'target'],
        'nav_from'                  => ['name' => 'nav_from', 'type' => 'string', 'internal' => 'from'],
        'nav_order'                 => ['name' => 'nav_order', 'type' => 'int', 'internal' => 'order'],
        'nav_parent'                => ['name' => 'nav_parent', 'type' => 'int', 'internal' => 'parent'],
        'nav_permission_permission' => ['name' => 'nav_permission_permission', 'type' => 'int', 'internal' => 'permissionPerm'],
        'nav_permission_type'       => ['name' => 'nav_permission_type', 'type' => 'int', 'internal' => 'permissionType'],
        'nav_permission_element'    => ['name' => 'nav_permission_element', 'type' => 'int', 'internal' => 'permissionElement'],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = 'nav';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = 'nav_id';
}