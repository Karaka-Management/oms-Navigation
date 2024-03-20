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

namespace Modules\Navigation\tests\Views;

use Modules\Navigation\Views\NavigationView;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\Navigation\Views\NavigationView::class)]
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

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testDefault() : void
    {
        self::assertEquals(0, $this->view->getNavId());
        self::assertEquals([], $this->view->getNav());
        self::assertEquals(0, $this->view->parent);
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testNavIdInputOutput() : void
    {
        $this->view->setNavId(2);
        self::assertEquals(2, $this->view->getNavId());
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testNavInputOutput() : void
    {
        $this->view->setNav([1, 2, 3]);
        self::assertEquals([1, 2, 3], $this->view->getNav());
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testParentInputOutput() : void
    {
        $this->view->parent = 4;
        self::assertEquals(4, $this->view->parent);
    }
}
