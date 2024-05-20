<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
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
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Navigation\Models\Navigation::class)]
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
        $this->nav = Navigation::getInstance($request, $account, $GLOBALS['dbpool'], 1, 2);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testDefault() : void
    {
        self::assertTrue(!empty($this->nav->getNav()));
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testGetInstanceInvalidHashes() : void
    {
        TestUtils::setMember($this->nav, 'instance', null);

        $this->expectException(\Exception::class);

        $account = AccountMapper::getWithPermissions(9999);
        $nav     = Navigation::getInstance(null, $account, $GLOBALS['dbpool'], 1, 2);
    }
}
