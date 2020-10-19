<?php declare(strict_types=1);

namespace Autograph\Tests\Map;

use Autograph\Map\Annotations\ObjectType;
use Autograph\Map\Enums\QueryMethod;
use Autograph\Map\MappedObjectType;
use Autograph\Tests\Application\Entities\Album;
use Doctrine\ORM\Mapping\MappingException;
use ReflectionException;
use Tests\TestCase;

/**
 * Class AnnotationMapperTest
 * @package Autograph\Tests\Map
 */
class MappedObjectTypeTest extends TestCase
{
    /**
     * @throws MappingException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     * @throws ReflectionException
     */
    public function testGetName()
    {
        $objectType = new ObjectType();
        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Album::class);
        $obj = new MappedObjectType($objectType, $meta);
        $this->assertEquals('Album', $obj->getName());

        $objectType->name = 'Albums';
        $this->assertEquals('Albums', $obj->getName());
    }

    /**
     * @throws MappingException
     * @throws ReflectionException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     */
    public function testGetDescription()
    {
        $objectType = new ObjectType();
        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Album::class);
        $obj = new MappedObjectType($objectType, $meta);
        $this->assertNull($obj->getDescription());

        $objectType->description = 'A Category';
        $this->assertEquals('A Category', $obj->getDescription());
    }

    /**
     * @throws MappingException
     * @throws ReflectionException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     */
    public function testGetQueryMethod()
    {
        $objectType = new ObjectType();
        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Album::class);
        $obj = new MappedObjectType($objectType, $meta);
        $this->assertEquals(QueryMethod::NONE(), $obj->getQueryMethod());

        $objectType->query = ['method' => 'list'];
        $this->assertEquals(QueryMethod::LIST(), $obj->getQueryMethod());

        $objectType->query = ['method' => 'single'];
        $this->assertEquals(QueryMethod::SINGLE(), $obj->getQueryMethod());
    }

    /**
     * @throws MappingException
     * @throws ReflectionException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     */
    public function testGetQueryField()
    {
        $objectType = new ObjectType();
        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Album::class);
        $obj = new MappedObjectType($objectType, $meta);
        $this->assertEquals('Album', $obj->getQueryFieldName());

        $objectType->query = ['fieldName' => 'albums'];
        $this->assertEquals('albums', $obj->getQueryFieldName());
    }
}
