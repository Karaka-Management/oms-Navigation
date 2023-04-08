<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\Navigation
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Navigation\Controller;

use Model\NullSetting;
use Model\SettingMapper;
use Modules\Admin\Models\AppMapper;
use Modules\Navigation\Models\NavElementMapper;
use Modules\Navigation\Models\Navigation;
use Modules\Navigation\Views\NavigationView;
use phpOMS\Contract\RenderableInterface;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * Navigation class.
 *
 * @package Modules\Navigation
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 * @codeCoverageIgnore
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
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function createNavigationMid(int $pageId, RequestAbstract $request, ResponseAbstract $response) : NavigationView
    {
        $nav = Navigation::getInstance(
            $request,
            $this->app->accountManager->get($request->header->account),
            $this->app->dbPool,
            $this->app->unitId,
            $this->app->appId
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
            $this->app->unitId,
            $this->app->appId
        );

        $nav = new NavigationView($this->app->l11nManager, $request, $response);
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

        // Add application navigation
        $languages[] = '/Web/' . ($this->app->appName) . '/lang/Navigation';

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
        $nav = Navigation::getInstance(
            $request,
            $this->app->accountManager->get($request->header->account),
            $this->app->dbPool,
            $this->app->unitId,
            $this->app->appId
        );

        $navView = new NavigationView($this->app->l11nManager, $request, $response);

        $navView->setTemplate('/Modules/Navigation/Theme/Backend/splash');
        $navView->setNav($nav->getNav());
        $navView->parent = $pageId;

        return $navView;
    }

    /**
     * Method which generates the module settings view.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface Response can be rendered
     *
     * @since 1.0.0
     */
    public function viewModuleSettings(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000105001, $request, $response));

        $id = $request->getDataString('id') ?? '';

        $settings = SettingMapper::getAll()->where('module', $id)->execute();
        if (!($settings instanceof NullSetting)) {
            $view->setData('settings', !\is_array($settings) ? [$settings] : $settings);
        }

        $navigation = NavElementMapper::getAll()->execute();
        $view->setData('navigation', $navigation);

        $view->setTemplate('/Modules/' . static::NAME . '/Admin/Settings/Theme/Backend/settings');

        return $view;
    }

    /**
     * Method which generates a navigation settings view.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface Response can be rendered
     *
     * @since 1.0.0
     */
    public function viewModuleNavElementSettings(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/' . static::NAME . '/Admin/Settings/Theme/Backend/settings-nav');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000105001, $request, $response));

        $view->addData('nav-element', NavElementMapper::get()->where('id', (int) $request->getData('nav'))->execute());

        return $view;
    }

    /**
     * Method which generates the module profile view.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface Response can be rendered
     *
     * @since 1.0.0
     */
    public function viewModuleNavigationList(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Modules/Navigation/Admin/Settings/Theme/Backend/modules-nav-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000105001, $request, $response));

        $module = $request->getDataString('id') ?? '';
        $view->setData('module', $module);

        $query = NavElementMapper::getAll()
            ->where('from', $module);

        if ($module === 'Navigation') {
            $query = $query->where('from', '0', connector: 'OR');
        }

        $activeNavElements = $query->execute();
        $view->setData('navs', $activeNavElements);

        $apps = AppMapper::getAll()->execute();
        $view->setData('apps', $apps);

        return $view;
    }
}
