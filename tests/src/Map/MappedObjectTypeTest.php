<?php declare(strict_types=1);

namespace Autograph\Tests\Map;

use Autograph\Map\Annotations\ObjectType;
use Autograph\Map\MappedObjectType;
use Autograph\Tests\Application\Entities\Categories;
use Tests\TestCase;

/**
 * Class AnnotationMapperTest
 * @package Autograph\Tests\Map
 */
class MappedObjectTypeTest extends TestCase
{
    public function testGetName()
    {
        $objectType = new ObjectType();
        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Categories::class);
        $obj = new MappedObjectType($objectType, $meta);
        $this->assertEquals('Categories', $obj->getName());

        $objectType->name = 'Category';
        $this->assertEquals('Category', $obj->getName());
    }

    public function testGetDescription()
    {
        $objectType = new ObjectType();
        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Categories::class);
        $obj = new MappedObjectType($objectType, $meta);
        $this->assertNull($obj->getDescription());

        $objectType->description = 'A Category';
        $this->assertEquals('A Category', $obj->getDescription());
    }
}
