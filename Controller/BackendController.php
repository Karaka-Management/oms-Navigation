<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Modules\Navigation
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
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
 * @package    Modules\Navigation
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
final class BackendController extends Controller
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
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function createNavigationMid(int $pageId, RequestAbstract $request, ResponseAbstract $response) : NavigationView
    {
        $nav = Navigation::getInstance($request,
            $this->app->accountManager->get($request->getHeader()->getAccount()),
            $this->app->dbPool,
            $this->app->orgId,
            $this->app->appName
        );

        $navView = new NavigationView($this->app, $request, $response);
        $navView->setTemplate('/Modules/Navigation/Theme/Backend/mid');
        $navView->setNav($nav->getNav());
        $navView->setParent($pageId);

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
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function getView(RequestAbstract $request, ResponseAbstract $response) : NavigationView
    {
        $navObj = \Modules\Navigation\Models\Navigation::getInstance(
            $request,
            $this->app->accountManager->get($request->getHeader()->getAccount()),
            $this->app->dbPool,
            $this->app->orgId,
            $this->app->appName
        );

        $nav = new \Modules\Navigation\Views\NavigationView($this->app, $request, $response);
        $nav->setNav($navObj->getNav());

        $unread = [];
        foreach ($this->receiving as $receiving) {
            $unread[$receiving] = $this->app->moduleManager->get($receiving)->openNav($request->getHeader()->getAccount());
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
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function loadLanguage(RequestAbstract $request, ResponseAbstract $response) : void
    {
        $languages = $this->app->moduleManager->getLanguageFiles($request);

        foreach ($languages as $path) {
            if ($path[strlen($path) - 1] === '/') {
                // Is not a navigation file
                continue;
            }

            $path = __DIR__ . '/../../..' . $path . '.' . $response->getHeader()->getL11n()->getLanguage() . '.lang.php';

            /** @noinspection PhpIncludeInspection */
            $lang = include $path;

            $this->app->l11nManager->loadLanguage($response->getHeader()->getL11n()->getLanguage(), 'Navigation', $lang);
        }
    }

    /**
     * @param int              $pageId   Page/parent Id for navigation
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     *
     * @return NavigationView
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function createNavigationSplash(int $pageId, RequestAbstract $request, ResponseAbstract $response) : NavigationView
    {
        $nav = Navigation::getInstance($request,
            $this->app->accountManager->get($request->getHeader()->getAccount()),
            $this->app->dbPool,
            $this->app->orgId,
            $this->app->appName
        );

        $navView = new NavigationView($this->app, $request, $response);

        $navView->setTemplate('/Modules/Navigation/Theme/Backend/splash');
        $navView->setNav($nav->getNav());
        $navView->setParent($pageId);

        return $navView;
    }
}