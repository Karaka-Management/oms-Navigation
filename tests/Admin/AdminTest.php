<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Navigation\tests\Admin;

use Modules\Admin\Models\AccountMapper;
use Modules\Navigation\Models\Navigation;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Module\ModuleManager;
use phpOMS\Uri\HttpUri;

/**
 * @internal
 */
final class AdminTest extends \PHPUnit\Framework\TestCase
{
    protected const NAME = 'Navigation';

    protected const URI_LOAD = '';

    use \Modules\tests\ModuleTestTrait;

    /**
     * Test if navigation model works correct
     *
     * @covers Modules\Navigation\Models\Navigation
     *
     * @group final
     * @group module
     */
    public function testNavigationElements() : void
    {
        $request = new HttpRequest(new HttpUri('http://127.0.0.1/en/backend'));
        $request->createRequestHashs(1);

        $account       = AccountMapper::getWithPermissions(1);
        $nav           = Navigation::getInstance($request, $account, $GLOBALS['dbpool'], 1, 'Backend')->getNav();

        self::assertGreaterThan(0, \count($nav));
    }
}
