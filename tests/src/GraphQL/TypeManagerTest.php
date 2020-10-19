<?php declare(strict_types=1);

namespace Autograph\Tests\GraphQL;

use Autograph\GraphQL\TypeManager;
use Autograph\Map\Annotations\ObjectType;
use Autograph\Map\MappedObjectType;
use Autograph\Map\ObjectFactory;
use Autograph\Tests\Application\Entities\Album;
use Doctrine\ORM\Mapping\MappingException;
use GraphQL\Type\Definition;
use ReflectionException;
use Tests\TestCase;

/**
 * Class TypeManagerTest
 * @package Autograph\Tests\GraphQL
 */
class TypeManagerTest  extends TestCase
{
    public function testScalars()
    {
        $this->assertInstanceOf(Definition\StringType::class, TypeManager::get('string'));
        $this->assertInstanceOf(Definition\IntType::class, TypeManager::get('int'));
        $this->assertInstanceOf(Definition\IDType::class, TypeManager::get('id'));
        $this->assertInstanceOf(Definition\FloatType::class, TypeManager::get('float'));
        $this->assertInstanceOf(Definition\BooleanType::class, TypeManager::get('boolean'));
    }

    /**
     * @throws MappingException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     * @throws ReflectionException
     */
    public function testExists()
    {
        $objectType = new ObjectType();
        $objectType->name = 'album';

        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Album::class);
        $obj = new MappedObjectType($objectType, $meta);

        TypeManager::add(ObjectFactory::create($obj));

        $this->assertTrue(TypeManager::exists('string'));
        $this->assertFalse(TypeManager::exists('unknown'));
        $this->assertTrue(TypeManager::exists('album'));
    }
}
