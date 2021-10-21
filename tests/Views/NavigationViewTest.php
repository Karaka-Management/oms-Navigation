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

namespace Modules\Navigation\tests\Views;

use Modules\Navigation\Views\NavigationView;

/**
 * @internal
 */
final class NavigationViewTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Navigation\Views\NavigationView
     * @group module
     */
    public function testDefault() : void
    {
        $view = new NavigationView();

        self::assertEquals(0, $view->getNavId());
        self::assertEquals([], $view->getNav());
        self::assertEquals(0, $view->parent);
    }

    /**
     * @covers Modules\Navigation\Views\NavigationView
     * @group module
     */
    public function testGetSet() : void
    {
        $view = new NavigationView();

        $view->setNavId(2);
        self::assertEquals(2, $view->getNavId());

        $view->setNav([1, 2, 3]);
        self::assertEquals([1, 2, 3], $view->getNav());

        $view->parent = 4;
        self::assertEquals(4, $view->parent);
    }
}
