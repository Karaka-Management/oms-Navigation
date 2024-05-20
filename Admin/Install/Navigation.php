<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Navigation\Admin\Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Navigation\Admin\Install;

use phpOMS\Application\ApplicationAbstract;
use phpOMS\System\File\PathException;
use phpOMS\System\File\PermissionException;
use phpOMS\Utils\Parser\Php\ArrayParser;

/**
 * Navigation class.
 *
 * @package Modules\Navigation\Admin\Install
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @performance Create a navigation language file (same as routing files) during the installation process per language
 *      https://github.com/Karaka-Management/oms-Navigation/issues/8
 */
class Navigation
{
    /**
     * Nav languages.
     *
     * @var array<string, array>
     * @since 1.0.0
     */
    private static array $nav = [];

    /**
     * Install navigation providing
     *
     * @param ApplicationAbstract $app  Application
     * @param string              $path Module path
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function install(ApplicationAbstract $app, string $path) : void
    {
        \Modules\Navigation\Admin\Installer::installExternal($app, ['path' => __DIR__ . '/Navigation.install.json']);
    }

    /**
     * Install language files.
     *
     * @param string $destPath Destination language path
     * @param string $srcPath  Source language path
     *
     * @return void
     *
     * @throws PathException
     * @throws PermissionException
     *
     * @since 1.0.0
     */
    protected static function installLanguageFiles(string $destPath, string $srcPath) : void
    {
        if (!\is_file($srcPath)) {
            return;
        }

        if (!\is_file($destPath)) {
            \file_put_contents($destPath, '<?php return [];');
        }

        if (!\is_file($destPath)) {
            throw new PathException($destPath); // @codeCoverageIgnore
        }

        if (!\is_writable($destPath)) {
            throw new PermissionException($destPath); // @codeCoverageIgnore
        }

        if (!isset(self::$nav[$destPath])) {
            /** @noinspection PhpIncludeInspection */
            self::$nav[$destPath] = include $destPath;
        }

        /** @noinspection PhpIncludeInspection */
        $language = include $srcPath;

        self::$nav[$destPath] = \array_merge_recursive(self::$nav[$destPath], $language);

        \file_put_contents($destPath, '<?php return ' . ArrayParser::serializeArray(self::$nav[$destPath]) . ';', \LOCK_EX);
    }
}
