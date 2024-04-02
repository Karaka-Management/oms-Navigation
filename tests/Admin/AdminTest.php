<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\Navigation\tests\Admin;

use Modules\Admin\Models\AccountMapper;
use Modules\Navigation\Models\Navigation;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Uri\HttpUri;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Navigation\Models\Navigation::class)]
final class AdminTest extends \PHPUnit\Framework\TestCase
{
    protected const NAME = 'Navigation';

    protected const URI_LOAD = '';

    use \tests\Modules\ModuleTestTrait;

    /**
     * Test if navigation model works correct
     */
    #[\PHPUnit\Framework\Attributes\Group('final')]
    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testNavigationElements() : void
    {
        $request = new HttpRequest(new HttpUri('http://127.0.0.1/en/backend'));
        $request->createRequestHashs(1);

        $account = AccountMapper::getWithPermissions(1);
        $nav     = Navigation::getInstance($request, $account, $GLOBALS['dbpool'], 1, 2)->getNav();

        self::assertGreaterThan(0, \count($nav));
    }
}
