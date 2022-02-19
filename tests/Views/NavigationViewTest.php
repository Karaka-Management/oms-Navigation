<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\Navigation\tests\Views;

use Modules\Navigation\Views\NavigationView;

/**
 * @internal
 */
final class NavigationViewTest extends \PHPUnit\Framework\TestCase
{
    private NavigationView $view;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->view = new NavigationView();
    }

    /**
     * @covers Modules\Navigation\Views\NavigationView
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->view->getNavId());
        self::assertEquals([], $this->view->getNav());
        self::assertEquals(0, $this->view->parent);
    }

    /**
     * @covers Modules\Navigation\Views\NavigationView
     * @group module
     */
    public function testNavIdInputOutput() : void
    {
        $this->view->setNavId(2);
        self::assertEquals(2, $this->view->getNavId());
    }

    /**
     * @covers Modules\Navigation\Views\NavigationView
     * @group module
     */
    public function testNavInputOutput() : void
    {
        $this->view->setNav([1, 2, 3]);
        self::assertEquals([1, 2, 3], $this->view->getNav());
    }

    /**
     * @covers Modules\Navigation\Views\NavigationView
     * @group module
     */
    public function testParentInputOutput() : void
    {
        $this->view->parent = 4;
        self::assertEquals(4, $this->view->parent);
    }
}
