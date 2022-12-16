<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\Navigation
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Navigation\Controller;

use Modules\Navigation\Models\Navigation;
use Modules\Navigation\Views\NavigationView;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * Navigation class.
 *
 * @package Modules\Navigation
 * @license OMS License 1.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class TimerecordingController extends Controller
{
    /**
     * Create mid navigation
     *
     * @param int              $pageId   Page/parent Id for navigation
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     *
     * @return NavigationView
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function createNavigationMid(int $pageId, RequestAbstract $request, ResponseAbstract $response) : NavigationView
    {
        $nav = Navigation::getInstance($request,
            $this->app->accountManager->get($request->header->account),
            $this->app->dbPool,
            $this->app->orgId,
            $this->app->appName
        );

        $navView = new NavigationView($this->app->l11nManager, $request, $response);
        $navView->setTemplate('/Modules/Navigation/Theme/Backend/mid');
        $navView->setNav($nav->getNav());
        $navView->parent = $pageId;

        return $navView;
    }

    /**
     * Get basic navigation view
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     *
     * @return NavigationView
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function getView(RequestAbstract $request, ResponseAbstract $response) : NavigationView
    {
        $navObj = Navigation::getInstance(
            $request,
            $this->app->accountManager->get($request->header->account),
            $this->app->dbPool,
            $this->app->orgId,
            $this->app->appName
        );

        $nav = new \Modules\Navigation\Views\NavigationView($this->app->l11nManager, $request, $response);
        $nav->setNav($navObj->getNav());

        $unread = [];
        foreach ($this->receiving as $receiving) {
            $unread[$receiving] = $this->app->moduleManager->get($receiving)->openNav($request->header->account);
        }

        $nav->setData('unread', $unread);

        return $nav;
    }

    /**
     * Load navigation language
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     *
     * @return void
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function loadLanguage(RequestAbstract $request, ResponseAbstract $response) : void
    {
        $languages = $this->app->moduleManager->getLanguageFiles($request);
        $langCode  = $response->getLanguage();

        foreach ($languages as $path) {
            $path = __DIR__ . '/../../..' . $path . '.' . $langCode . '.lang.php';

            if (!\is_file($path)) {
                continue;
            }

            /** @noinspection PhpIncludeInspection */
            $lang = include $path;

            $this->app->l11nManager->loadLanguage($langCode, 'Navigation', $lang);
        }
    }

    /**
     * @param int              $pageId   Page/parent Id for navigation
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     *
     * @return NavigationView
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function createNavigationSplash(int $pageId, RequestAbstract $request, ResponseAbstract $response) : NavigationView
    {
        $nav = Navigation::getInstance($request,
            $this->app->accountManager->get($request->header->account),
            $this->app->dbPool,
            $this->app->orgId,
            $this->app->appName
        );

        $navView = new NavigationView($this->app->l11nManager, $request, $response);

        $navView->setTemplate('/Modules/Navigation/Theme/Timerecording/splash');
        $navView->setNav($nav->getNav());
        $navView->parent = $pageId;

        return $navView;
    }
}
