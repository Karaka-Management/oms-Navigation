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
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\NotificationLevel;
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

        /** @var \Modules\Navigation\Models\NavElement[] $elements */
        $elements = NavElementMapper::getAll();

        $searchIdStartPos = \stripos($request->getData('search'), ':');
        $patternStartPos  = $searchIdStartPos === false ? -1 : \stripos(
                $request->getData('search'),
                ' ',
                $searchIdStartPos
            );

        $search = \mb_strtolower(\substr(
            $request->getData('search'),
            $patternStartPos + 1
        ));

        $found = null;
        foreach ($elements as $element) {
            if (empty($element->uri)) {
                continue;
            }

            $name = \mb_strtolower($this->app->l11nManager->getText(
                $response->getLanguage() ?? 'en',
                'Navigation', '0',
                $element->name,
            ));

            if ($name === $search) {
                $found = $element;
                break;
            }
        }

        $response->header->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);

        if ($found === null || $found->uri === null) {
            $this->fillJsonResponse($request, $response, NotificationLevel::WARNING, 'Command', 'Unknown command "' . $search . '"', $search);
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $response->set($request->uri->__toString(), new Redirect(UriFactory::build($found->uri)));
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
     * @since 1.0.0
     */
    private function loadLanguage(RequestAbstract $request, ResponseAbstract $response, string $app) : void
    {
        $languages = $this->app->moduleManager->getLanguageFiles($request, $app);
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
}
