<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Navigation\tests\Controller;

use Model\CoreSettings;
use Modules\Admin\Models\AccountPermission;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Account\PermissionType;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Model\Message\Redirect;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\WebRouter;
use phpOMS\Uri\HttpUri;
use phpOMS\Utils\TestUtils;

/**
 * @testdox Modules\Navigation\tests\Controller\SearchControllerTest: Admin api controller
 *
 * @internal
 */
final class SearchControllerTest extends \PHPUnit\Framework\TestCase
{
    protected ApplicationAbstract $app;

    /**
     * @var \Modules\Navigation\Controller\SearchController
     */
    protected ModuleAbstract $module;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->app = new class() extends ApplicationAbstract
        {
            protected string $appName = 'Search';
        };

        $this->app->dbPool          = $GLOBALS['dbpool'];
        $this->app->unitId          = 1;
        $this->app->accountManager  = new AccountManager($GLOBALS['session']);
        $this->app->appSettings     = new CoreSettings();
        $this->app->moduleManager   = new ModuleManager($this->app, __DIR__ . '/../../../../Modules/');
        $this->app->dispatcher      = new Dispatcher($this->app);
        $this->app->l11nManager     = new L11nManager();
        $this->app->eventManager    = new EventManager($this->app->dispatcher);
        $this->app->eventManager->importFromFile(__DIR__ . '/../../../../Web/Api/Hooks.php');

        $account = new Account();
        TestUtils::setMember($account, 'id', 1);

        $permission       = new AccountPermission();
        $permission->unit = 1;
        $permission->app  = 2;
        $permission->setPermission(
            PermissionType::READ
            | PermissionType::CREATE
            | PermissionType::MODIFY
            | PermissionType::DELETE
            | PermissionType::PERMISSION
        );

        $account->addPermission($permission);

        $this->app->accountManager->add($account);
        $this->app->router = new WebRouter();

        $this->module = $this->app->moduleManager->get('Navigation');

        TestUtils::setMember($this->module, 'app', $this->app);
    }

    /**
     * @covers Modules\Navigation\Controller\SearchController
     * @group module
     */
    public function testGotoSearch() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri('https://127.0.0.1/en/backend'));
        $request->createRequestHashs(2);

        $request->header->account = 1;
        $request->setData('search', ':goto General');
        $request->setData('app', 'Backend');

        $this->module->searchGoto($request, $response);
        self::assertInstanceOf(Redirect::class, $response->get('https://127.0.0.1/en/backend'));
    }

    /**
     * @covers Modules\Navigation\Controller\SearchController
     * @group module
     */
    public function testInvalidGotoSearch() : void
    {
        $response = new HttpResponse();
        $request  = new HttpRequest(new HttpUri('https://127.0.0.1/en/backend'));
        $request->createRequestHashs(0);

        $request->header->account = 1;
        $request->setData('search', ':goto Invalid');
        $request->setData('app', 'Backend');

        $this->module->searchGoto($request, $response);
        self::assertEquals(RequestStatusCode::R_400, $response->header->status);
    }
}
