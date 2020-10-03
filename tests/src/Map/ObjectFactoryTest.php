<?php declare(strict_types=1);

namespace Autograph\Tests\Map;

use Autograph\Exceptions\GeneralException;
use Autograph\Map\Annotations\ObjectType;
use Autograph\Map\MappedObjectField;
use Autograph\Map\MappedObjectType;
use Autograph\Map\ObjectFactory;
use Autograph\Tests\Application\Entities\Categories;
use Doctrine\Persistence\Mapping\MappingException;
use ReflectionException;
use ReflectionProperty;
use Tests\TestCase;
use GraphQL\Type\Definition\ObjectType as GraphQLObject;


/**
 * Class ObjectFactoryTest
 * @package Autograph\Tests\Map
 */
class ObjectFactoryTest extends TestCase
{

    /**
     * @throws GeneralException
     * @throws MappingException
     * @throws ReflectionException
     */
    public function testCreate()
    {
        $objectType = new ObjectType();
        $objectType->name = 'category';
        $objectType->description = 'A category';

        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Categories::class);

        $objectType = new MappedObjectType($objectType, $meta);

        $type = ObjectFactory::create($objectType);

        $this->assertInstanceOf(GraphQLObject::class, $type);
    }
}
