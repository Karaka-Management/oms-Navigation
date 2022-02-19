<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\Navigation\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\Navigation\Admin;

use Modules\Navigation\Models\NavElement;
use Modules\Navigation\Models\NavElementMapper;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InstallerAbstract;
use phpOMS\System\File\PathException;

/**
 * Installer class.
 *
 * @package Modules\Navigation\Admin
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
final class Installer extends InstallerAbstract
{
    /**
     * Path of the file
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;

    /**
     * Install data from providing modules.
     *
     * @param ApplicationAbstract $app  Application
     * @param array               $data Additional data
     *
     * @return array
     *
     * @throws PathException This exception is thrown if the Navigation install file couldn't be found
     * @throws \Exception    This exception is thrown if the Navigation install file is invalid json
     *
     * @since 1.0.0
     */
    public static function installExternal(ApplicationAbstract $app, array $data) : array
    {
        try {
            $app->dbPool->get()->con->query('select 1 from `nav`');
        } catch (\Exception $e) {
            return []; // @codeCoverageIgnore
        }

        $navFile = \file_get_contents($data['path'] ?? '');
        if ($navFile === false) {
            throw new PathException($data['path'] ?? ''); // @codeCoverageIgnore
        }

        $navData = \json_decode($navFile, true);
        if ($navData === false) {
            throw new \Exception(); // @codeCoverageIgnore
        }

        foreach ($navData as $link) {
            self::installLink($app->dbPool, $link, $data['app'] ?? null);
        }

        return [];
    }

    /**
     * Install navigation element.
     *
     * @param DatabasePool $dbPool Database instance
     * @param array        $data   Link info
     * @param int          $app    App
     *
     * @return void
     *
     * @since 1.0.0
     */
    private static function installLink(DatabasePool $dbPool, array $data, int $app = null) : void
    {
        $navElement = new NavElement();

        $navElement->id                = (int) ($data['id'] ?? 0);
        $navElement->pid               = \sha1(\str_replace('/', '', $data['pid'] ?? ''));
        $navElement->pidRaw            = $data['pid'] ?? '';
        $navElement->name              = (string) ($data['name'] ?? '');
        $navElement->type              = (int) ($data['type'] ?? 1);
        $navElement->subtype           = (int) ($data['subtype'] ?? 2);
        $navElement->icon              = $data['icon'] ?? null;
        $navElement->uri               = $data['uri'] ?? null;
        $navElement->target            = (string) ($data['target'] ?? 'self');
        $navElement->action            = $data['action'] ?? null;
        $navElement->app               = (int) ($data['app'] ?? ($app ?? 2));
        $navElement->from              = (string) ($data['from'] ?? '0');
        $navElement->order             = (int) ($data['order'] ?? 1);
        $navElement->parent            = (int) ($data['parent'] ?? 0);
        $navElement->permissionPerm    = $data['permission']['permission'] ?? null;
        $navElement->permissionType    = $data['permission']['type'] ?? null;
        $navElement->permissionElement = $data['permission']['element'] ?? null;

        NavElementMapper::create()->execute($navElement);

        foreach ($data['children'] as $link) {
            self::installLink($dbPool, $link);
        }
    }
}
