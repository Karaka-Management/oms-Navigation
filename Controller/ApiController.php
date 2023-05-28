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

use Modules\Navigation\Models\NavElement;
use Modules\Navigation\Models\NavElementMapper;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\NotificationLevel;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Message\FormValidation;

/**
 * Api controller for the tasks module.
 *
 * @package Modules\Navigation
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiController extends Controller
{
    /**
     * Api method to create tag
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
    public function apiNavElementCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateNavElementCreate($request))) {
            $response->set('nav_element_create', new FormValidation($val));
            $response->header->status = RequestStatusCode::R_400;

            return;
        }

        $navElement = $this->createNavElementFromRequest($request);
        $this->createModel($request->header->account, $navElement, NavElementMapper::class, 'nav_element', $request->getOrigin());

        $this->fillJsonResponse($request, $response, NotificationLevel::OK, 'Navigation Element', 'Element successfully created', $navElement);
    }

    /**
     * Validate tag create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateNavElementCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['name'] = !$request->hasData('name'))) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create tag from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return NavElement
     *
     * @since 1.0.0
     */
    private function createNavElementFromRequest(RequestAbstract $request) : NavElement
    {
        $navElement = new NavElement();

        $navElement->id                 = (int) $request->getData('id');
        $navElement->pid                = \sha1(\str_replace('/', '', $request->getDataString('pid') ?? ''));
        $navElement->pidRaw             = $request->getDataString('pid') ?? '';
        $navElement->name               = (string) ($request->getDataString('name') ?? '');
        $navElement->type               = $request->getDataInt('type') ?? 1;
        $navElement->subtype            = $request->getDataInt('subtype') ?? 2;
        $navElement->icon               = $request->getDataString('icon');
        $navElement->uri                = $request->getDataString('uri');
        $navElement->target             = (string) ($request->getData('target') ?? 'self');
        $navElement->action             = $request->getDataString('action');
        $navElement->app                = $request->getDataInt('app') ?? 2;
        $navElement->from               = empty($from = $request->getDataString('from') ?? '') ? '0' : $from;
        $navElement->order              = $request->getDataInt('order') ?? 1;
        $navElement->parent             = $request->getDataInt('parent') ?? 0;
        $navElement->permissionPerm     = $request->getDataInt('permission');
        $navElement->permissionCategory = $request->getDataInt('category');
        $navElement->permissionElement  = $request->getDataInt('element');

        return $navElement;
    }
}
