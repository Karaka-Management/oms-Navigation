<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\Navigation\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Navigation\Admin;

use Modules\Navigation\Models\NavElement;
use Modules\Navigation\Models\NavElementMapper;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InstallerAbstract;
use phpOMS\System\File\PathException;
use phpOMS\Utils\Parser\Php\ArrayParser;

/**
 * Installer class.
 *
 * @package Modules\Navigation\Admin
 * @license OMS License 1.0
 * @link    https://jingga.app
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
     * @param ApplicationAbstract                         $app  Application
     * @param array{path?:string, lang?:string, app?:int} $data Additional data
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
        if (!\is_array($navData)) {
            throw new \Exception(); // @codeCoverageIgnore
        }

        if (($data['lang'] ?? null) !== null) {
            self::installNavigationLanguage($data['lang'], $app->appName);
        }

        foreach ($navData as $link) {
            self::installLink($app->dbPool, $link, $data['app'] ?? null);
        }

        return [];
    }

    /**
     * Install language file for navigation
     *
     * @param string $path    Path of the navigation language files
     * @param string $appName Application name of the navigation elements
     *
     * @return void
     *
     * @since 1.0.0
     */
    private static function installNavigationLanguage(string $path, string $appName) : void
    {
        $files = \scandir($path);
        if ($files === false) {
            return;
        }

        foreach ($files as $file) {
            if (\stripos($file, 'Navigation') !== 0) {
                continue;
            }

            $localization = include \rtrim($path, '/') . '/' . $file;

            if (!\is_file($langPath = __DIR__ . '/../../../Web/' . $appName . '/lang/' . $file)) {
                \copy(__DIR__ . '/Install/NavigationSkeleton.php', $langPath);
            }

            $base = include $langPath;
            $new  = \array_merge($base, $localization);
            \file_put_contents($langPath, '<?php return ' . ArrayParser::serializeArray($new) . ';');
        }
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
        // @todo: implement in the api and then make an api call becuse we also want to be able to install
        // navigation elements manually through the user interface?!
        $navElement = new NavElement();

        $navElement->id                 = (int) ($data['id'] ?? 0);
        $navElement->pid                = \sha1(\str_replace('/', '', $data['pid'] ?? ''));
        $navElement->pidRaw             = $data['pid'] ?? '';
        $navElement->name               = (string) ($data['name'] ?? '');
        $navElement->type               = (int) ($data['type'] ?? 1);
        $navElement->subtype            = (int) ($data['subtype'] ?? 2);
        $navElement->icon               = $data['icon'] ?? null;
        $navElement->uri                = $data['uri'] ?? null;
        $navElement->target             = (string) ($data['target'] ?? 'self');
        $navElement->action             = $data['action'] ?? null;
        $navElement->app                = (int) ($data['app'] ?? ($app ?? 2));
        $navElement->from               = empty($from = (string) ($data['from'] ?? '')) ? '0' : $from;
        $navElement->order              = (int) ($data['order'] ?? 1);
        $navElement->parent             = (int) ($data['parent'] ?? 0);
        $navElement->permissionPerm     = $data['permission']['permission'] ?? null;
        $navElement->permissionCategory = $data['permission']['category'] ?? null;
        $navElement->permissionElement  = $data['permission']['element'] ?? null;

        NavElementMapper::create()->execute($navElement);

        foreach ($data['children'] as $link) {
            self::installLink($dbPool, $link, $app);
        }
    }
}
