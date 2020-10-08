<?php declare(strict_types=1);

namespace Autograph\Tests\Map;

use Autograph\Map\Annotations\ObjectType;
use Autograph\Map\MappedObjectType;
use Autograph\Map\ObjectFactory;
use Autograph\Tests\Application\Entities\Album;
use Doctrine\Persistence\Mapping\MappingException;
use GraphQL\Type\Definition\ObjectType as GraphQLObject;
use ReflectionException;
use Tests\TestCase;

/**
 * Class ObjectFactoryTest
 * @package Autograph\Tests\Map
 */
class ObjectFactoryTest extends TestCase
{
    /**
     * @throws MappingException
     * @throws ReflectionException
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function testCreate()
    {
        $objectType = new ObjectType();
        $objectType->name = 'category';
        $objectType->description = 'A category';

        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Album::class);

        $objectType = new MappedObjectType($objectType, $meta);

        $type = ObjectFactory::create($objectType);

        $this->assertInstanceOf(GraphQLObject::class, $type);
    }
}
