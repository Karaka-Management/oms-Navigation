<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\Navigation\tests\Models;

use Modules\Admin\Models\AccountMapper;
use Modules\Navigation\Models\Navigation;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Uri\HttpUri;
use phpOMS\Utils\TestUtils;

/**
 * @internal
 */
final class NavigationTest extends \PHPUnit\Framework\TestCase
{
    private Navigation $nav;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $request = new HttpRequest(new HttpUri('http://127.0.0.1/en/backend'));
        $request->createRequestHashs(1);

        $account   = AccountMapper::getWithPermissions(9999);
        $this->nav = Navigation::getInstance($request, $account, $GLOBALS['dbpool'], 1, 'Backend');
    }

    /**
     * @covers Modules\Navigation\Models\Navigation
     * @group module
     */
    public function testDefault() : void
    {
        self::assertTrue(\count($this->nav->getNav()) > 0);
    }

    /**
     * @covers Modules\Navigation\Models\Navigation
     * @group module
     */
    public function testGetInstanceInvalidHashes() : void
    {
        TestUtils::setMember($this->nav, 'instance', null);

        $this->expectException(\Exception::class);

        $account = AccountMapper::getWithPermissions(9999);
        $nav     = Navigation::getInstance(null, $account, $GLOBALS['dbpool'], 1, 'Backend');
    }
}
