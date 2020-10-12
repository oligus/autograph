<?php declare(strict_types=1);

namespace Autograph\Tests\GraphQL\Types;

use Autograph\GraphQL\Types\Filter;
use Autograph\Map\Annotations\ObjectType;
use Autograph\Map\MappedObjectType;
use Autograph\Tests\Application\Entities\Album;
use Doctrine\ORM\Mapping\MappingException;
use ReflectionException;
use Tests\TestCase;

/**
 * Class FilterTest
 * @package Autograph\Tests\GraphQL\Types
 */
class FilterTest extends TestCase
{

    /**
     * @throws MappingException
     * @throws \Doctrine\Persistence\Mapping\MappingException
     * @throws ReflectionException
     */
    public function testCreate()
    {
        $objectType = new ObjectType();
        $meta = $this->getEntityManager()->getMetadataFactory()->getMetadataFor(Album::class);
        $obj = new MappedObjectType($objectType, $meta);

        $filter = Filter::create($obj)['type'];

        $this->assertEquals('AlbumFilter', $filter->name);
    }
}
