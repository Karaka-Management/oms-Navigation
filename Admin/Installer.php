<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Navigation\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Navigation\Admin;

use phpOMS\Application\ApplicationAbstract;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Module\InstallerAbstract;
use phpOMS\System\File\PathException;
use phpOMS\Uri\HttpUri;
use phpOMS\Utils\Parser\Php\ArrayParser;

/**
 * Installer class.
 *
 * @package Modules\Navigation\Admin
 * @license OMS License 2.0
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
        } catch (\Exception $_) {
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
            self::installLink($app, $link, $data['app'] ?? null);
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
     * @param ApplicationAbstract $app   Application
     * @param array               $data  Link info
     * @param int                 $appId App
     *
     * @return void
     *
     * @since 1.0.0
     */
    private static function installLink(ApplicationAbstract $app, array $data, int $appId = null) : void
    {
        /** @var \Modules\Navigation\Controller\ApiController $module */
        $module = $app->moduleManager->getModuleInstance('Navigation');

        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri(''));

        $request->header->account = 1;
        $request->setData('id', (int) ($data['id'] ?? 0));
        $request->setData('pid', $data['pid'] ?? '');
        $request->setData('name', (string) ($data['name'] ?? ''));
        $request->setData('type', (int) ($data['type'] ?? 1));
        $request->setData('subtype', (int) ($data['subtype'] ?? 2));
        $request->setData('icon', $data['icon'] ?? null);
        $request->setData('uri', $data['uri'] ?? null);
        $request->setData('target', (string) ($data['target'] ?? 'self'));
        $request->setData('action', $data['action'] ?? null);
        $request->setData('app', (int) ($data['app'] ?? ($appId ?? 2)));
        $request->setData('from', empty($from = (string) ($data['from'] ?? '')) ? '0' : $from);
        $request->setData('order', (int) ($data['order'] ?? 1));
        $request->setData('parent', (int) ($data['parent'] ?? 0));
        $request->setData('permission', $data['permission']['permission'] ?? null);
        $request->setData('category', $data['permission']['category'] ?? null);
        $request->setData('element', $data['permission']['element'] ?? null);

        $module->apiNavElementCreate($request, $response);

        foreach ($data['children'] as $link) {
            self::installLink($app, $link, $appId);
        }
    }
}
