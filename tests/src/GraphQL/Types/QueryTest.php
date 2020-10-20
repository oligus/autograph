<?php declare(strict_types=1);

namespace Autograph\Tests\GraphQL\Types;

use Autograph\GraphQL\Types\Query;
use Autograph\Map\AnnotationMapper;
use Doctrine\ORM\Mapping\MappingException;
use GraphQL\Type\Definition\ObjectType;
use Tests\TestCase;

/**
 * Class QueryTest
 * @package Autograph\Tests\GraphQL\Types
 */
class QueryTest extends TestCase
{

    /**
     * @throws MappingException
     */
    public function testCreate()
    {
        $em = $this->getEntityManager();

        $mapper = new AnnotationMapper($em);

        $query = Query::create($mapper);

        $this->assertInstanceOf(ObjectType::class, $query);

        $expected = [
            'albums',
            'tracks'
        ];
        $this->assertEquals($expected, array_keys($query->getFields()));
    }
}
