<?php declare(strict_types=1);

namespace Autograph\Tests\GraphQL;

use Autograph\GraphQL\TypeManager;
use GraphQL\Type\Definition;
use Tests\TestCase;

/**
 * Class TypeManagerTest
 * @package Autograph\Tests\GraphQL
 */
class TypeManagerTest extends TestCase
{
    public function testScalars()
    {
        $this->assertInstanceOf(Definition\StringType::class, TypeManager::get('string'));
        $this->assertInstanceOf(Definition\IntType::class, TypeManager::get('int'));
        $this->assertInstanceOf(Definition\IDType::class, TypeManager::get('id'));
        $this->assertInstanceOf(Definition\FloatType::class, TypeManager::get('float'));
        $this->assertInstanceOf(Definition\BooleanType::class, TypeManager::get('boolean'));
    }
}
