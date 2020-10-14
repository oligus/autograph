<?php declare(strict_types=1);

namespace Autograph\Tests\GraphQL\Resolvers;

use Autograph\GraphQL\Resolvers\EntityList;
use Autograph\GraphQL\TypeManager;
use Autograph\Map\Annotations\ObjectType;
use Autograph\Map\MappedObjectType;
use Autograph\Map\ObjectFactory;
use Autograph\Tests\Application\Entities\Album;
use Doctrine\ORM\Mapping\MappingException;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType as ObjType;
use ReflectionException;
use Tests\TestCase;

/**
 * Class TypeManagerTest
 * @package Autograph\Tests\GraphQL
 */
class EntityListTest extends TestCase
{
    /**
     * @throws MappingException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     * @throws ReflectionException
     */
    public function testGetFields()
    {
        $objectType = new ObjectType();
        $objectType->name = 'album';
        $objectType->description = 'A category';

        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Album::class);
        $obj = new MappedObjectType($objectType, $meta);

        TypeManager::add(ObjectFactory::create($obj));

        $resolver = new EntityList($obj);

        $field = $resolver->getField();
        $this->assertInstanceOf(ObjType::class, ($field['album']['type']));

        TypeManager::clear();
    }
}
