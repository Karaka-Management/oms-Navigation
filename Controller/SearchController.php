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

namespace Modules\Navigation\Controller;

use Modules\Navigation\Models\NavElementMapper;
use Modules\Navigation\Models\Navigation;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Message\Redirect;
use phpOMS\System\MimeType;
use phpOMS\Uri\UriFactory;

/**
 * Search class.
 *
 * @package Modules\Navigation
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class SearchController extends Controller
{
    /**
     * Api method to create a task
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function searchGoto(RequestAbstract $request, ResponseAbstract $response, $data = null) : void
    {
        $this->loadLanguage($request, $response, $request->getData('app'));

        $elements = NavElementMapper::getAll();
        $search   = \explode(' ', $request->getData('search'))[1];

        $found = null;
        foreach ($elements as $element) {
            if (empty($element->uri)) {
                continue;
            }

            $name = $this->app->l11nManager->getText(
                $response->getHeader()->getL11n()->getLanguage() ?? 'en',
                'Navigation', '0',
                $element->name,
            );

            if ($name === $search) {
                $found = $element;
                break;
            }
        }

        $response->getHeader()->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);
        $response->set($request->getUri()->__toString(), new Redirect(UriFactory::build($found->uri)));
    }

    /**
     * Load navigation language
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param string           $app      App name
     *
     * @return void
     *
     * @todo Orange-Management/Modules#190 & Orange-Management/Modules#181
     *  The loading of the language file is slow since every module is loaded separately.
     *  This should either get cached per user or maybe put into one large language file per language (like the routes).
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    private function loadLanguage(RequestAbstract $request, ResponseAbstract $response, string $app) : void
    {
        $languages = $this->app->moduleManager->getLanguageFiles($request, $app);
        $langCode  = $response->getHeader()->getL11n()->getLanguage();

        foreach ($languages as $path) {
            $path = __DIR__ . '/../../..' . $path . '.' . $langCode . '.lang.php';

            if (!\file_exists($path)) {
                continue;
            }

            /** @noinspection PhpIncludeInspection */
            $lang = include $path;

            $this->app->l11nManager->loadLanguage($langCode, 'Navigation', $lang);
        }
    }
}
