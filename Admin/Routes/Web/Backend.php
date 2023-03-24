<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\Navigation\Controller\BackendController;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/admin/module/settings\?id=Navigation&nav=.*?$' => [
        [
            'dest'       => '\Modules\Navigation\Controller\BackendController:viewModuleNavElementSettings',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => \Modules\Admin\Models\PermissionCategory::MODULE,
            ],
        ],
    ],
    '^.*/admin/module/navigation/list\?.*$' => [
        [
            'dest'       => '\Modules\Navigation\Controller\BackendController:viewModuleNavigationList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => \Modules\Admin\Models\PermissionCategory::MODULE,
            ],
        ],
    ],
];
