<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Navigation
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\Navigation\Controller\SearchController;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^:goto (\?.*$|$)' => [
        [
            'dest'       => '\Modules\Navigation\Controller\SearchController:searchGoto',
            'verb'       => RouteVerb::ANY,
            'permission' => [
                'module' => SearchController::NAME,
                'type'   => PermissionType::READ,
            ],
        ],
    ],
];
