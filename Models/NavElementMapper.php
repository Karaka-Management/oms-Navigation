<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\Navigation\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Navigation\Models;

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Mapper class.
 *
 * @package Modules\Navigation\Models
 * @license OMS License 1.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class NavElementMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'nav_id'                        => ['name' => 'nav_id',                    'type' => 'int',    'internal' => 'id'],
        'nav_app'                       => ['name' => 'nav_app',                   'type' => 'int',    'internal' => 'app'],
        'nav_pid'                       => ['name' => 'nav_pid',                   'type' => 'string', 'internal' => 'pid'],
        'nav_pid_raw'                   => ['name' => 'nav_pid_raw',               'type' => 'string', 'internal' => 'pidRaw'],
        'nav_name'                      => ['name' => 'nav_name',                  'type' => 'string', 'internal' => 'name'],
        'nav_type'                      => ['name' => 'nav_type',                  'type' => 'int',    'internal' => 'type'],
        'nav_subtype'                   => ['name' => 'nav_subtype',               'type' => 'int',    'internal' => 'subtype'],
        'nav_icon'                      => ['name' => 'nav_icon',                  'type' => 'string', 'internal' => 'icon'],
        'nav_uri'                       => ['name' => 'nav_uri',                   'type' => 'string', 'internal' => 'uri'],
        'nav_target'                    => ['name' => 'nav_target',                'type' => 'string', 'internal' => 'target'],
        'nav_action'                    => ['name' => 'nav_action',                'type' => 'string', 'internal' => 'action'],
        'nav_from'                      => ['name' => 'nav_from',                  'type' => 'string', 'internal' => 'from'],
        'nav_order'                     => ['name' => 'nav_order',                 'type' => 'int',    'internal' => 'order'],
        'nav_parent'                    => ['name' => 'nav_parent',                'type' => 'int',    'internal' => 'parent'],
        'nav_permission_permission'     => ['name' => 'nav_permission_permission', 'type' => 'int',    'internal' => 'permissionPerm'],
        'nav_permission_category'       => ['name' => 'nav_permission_category',       'type' => 'int',    'internal' => 'permissionCategory'],
        'nav_permission_element'        => ['name' => 'nav_permission_element',    'type' => 'int',    'internal' => 'permissionElement'],
        'nav_status'                    => ['name' => 'nav_status',                'type' => 'int',    'internal' => 'status'],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string
     * @since 1.0.0
     */
    public const MODEL = NavElement::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'nav';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD ='nav_id';

    /**
     * Autoincrement primary field.
     *
     * @var bool
     * @since 1.0.0
     */
    public const AUTOINCREMENT = false;
}
