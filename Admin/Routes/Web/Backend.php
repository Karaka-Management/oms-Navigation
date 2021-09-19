<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use Modules\Navigation\Controller\BackendController;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
	'^.*/admin/module/settings\?id=Navigation.*$' => [
        [
            'dest'       => '\Modules\Navigation\Controller\BackendController:viewModuleSettings',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'   => PermissionType::READ,
                'state'  => \Modules\Admin\Models\PermissionState::MODULE,
            ],
        ],
    ],
];
