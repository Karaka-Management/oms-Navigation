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

namespace Modules\Navigation\tests\Models;

use Modules\Navigation\Models\NullNavElement;

/**
 * @internal
 */
final class NullNavElementTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\Navigation\Models\NullNavElement
     * @group module
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\Navigation\Models\NavElement', new NullNavElement());
    }

    /**
     * @covers Modules\Navigation\Models\NullNavElement
     * @group module
     */
    public function testId() : void
    {
        $null = new NullNavElement(2);
        self::assertEquals(2, $null->id);
    }

    /**
     * @covers Modules\Navigation\Models\NullNavElement
     * @group module
     */
    public function testJsonSerialize() : void
    {
        $null = new NullNavElement(2);
        self::assertEquals(['id' => 2], $null);
    }
}
