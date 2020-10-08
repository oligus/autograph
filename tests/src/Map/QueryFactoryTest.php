<?php declare(strict_types=1);

namespace Autograph\Tests\Map;

use Autograph\Map\AnnotationMapper;
use Autograph\Map\QueryFactory;
use Doctrine\ORM\Mapping\MappingException;
use GraphQL\Type\Definition\ObjectType;
use Tests\TestCase;

/**
 * Class QueryFactoryTest
 * @package Autograph\Tests\Map
 */
class QueryFactoryTest extends TestCase
{

    /**
     * @throws MappingException
     */
    public function testCreate()
    {
        $em = $this->getEntityManager();

        $mapper = new AnnotationMapper($em);

        $query = QueryFactory::create($mapper);

        $this->assertInstanceOf(ObjectType::class, $query);

        $expected = [
            'albums'
        ];
        $this->assertEquals($expected, array_keys($query->getFields()));
    }
}
