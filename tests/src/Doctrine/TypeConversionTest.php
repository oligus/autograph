<?php declare(strict_types=1);

namespace Autograph\Tests\Doctrine;

use Autograph\Doctrine\TypeConversion;
use GraphQL\Type\Definition\StringType;
use Tests\TestCase;

/**
 * Class MappingConversionTest
 * @package Autograph\Tests\Map
 */
class TypeConversionTest extends TestCase
{
    public function testText()
    {
        $conversion = new TypeConversion(['type' => 'text']);
        $this->assertInstanceOf(StringType::class, $conversion->getType());
    }

    public function testIsNullable()
    {
        $conversion = new TypeConversion(['nullable' => true]);
        $this->assertTrue($conversion->isNullable());
        $conversion = new TypeConversion(['nullable' => false]);
        $this->assertFalse($conversion->isNullable());
        $conversion = new TypeConversion([]);
        $this->assertFalse($conversion->isNullable());
    }
}
