<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\Navigation
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

use Modules\Navigation\Controller\SearchController;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^:goto .*$' => [
        [
            'dest' => '\Modules\Navigation\Controller\SearchController:searchGoto',
            'verb' => RouteVerb::ANY,
            'permission' => [
                'module' => SearchController::MODULE_NAME,
                'type'  => PermissionType::READ,
            ],
        ],
    ],
];
