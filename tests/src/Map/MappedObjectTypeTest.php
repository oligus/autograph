<?php declare(strict_types=1);

namespace Autograph\Tests\Map;

use Autograph\Map\Annotations\ObjectType;
use Autograph\Map\Enums\QueryType;
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
    public function testGetQueryType()
    {
        $objectType = new ObjectType();
        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Album::class);
        $obj = new MappedObjectType($objectType, $meta);
        $this->assertEquals(QueryType::NONE(), $obj->getQueryType());

        $objectType->queryType = 'list';
        $this->assertEquals(QueryType::LIST(), $obj->getQueryType());

        $objectType->queryType = 'single';
        $this->assertEquals(QueryType::SINGLE(), $obj->getQueryType());
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
        $this->assertEquals('Album', $obj->getQueryField());

        $objectType->queryField = 'albums';
        $this->assertEquals('albums', $obj->getQueryField());
    }

    /**
     * @throws MappingException
     * @throws ReflectionException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     */
    public function testGetFilterType()
    {
        $objectType = new ObjectType();
        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Album::class);
        $obj = new MappedObjectType($objectType, $meta);

        $filter = $obj->getFilterType()['type'];

        $this->assertEquals('AlbumFilter', $filter->name);
    }
}
