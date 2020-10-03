<?php declare(strict_types=1);

namespace Autograph\Tests\Map;

use Autograph\Exceptions\GeneralException;
use Autograph\Map\AnnotationMapper;
use Autograph\Map\QueryFactory;
use Doctrine\Persistence\Mapping\MappingException;
use GraphQL\Type\Definition\ObjectType;
use ReflectionException;
use Tests\TestCase;

/**
 * Class QueryFactoryTest
 * @package Autograph\Tests\Map
 */
class QueryFactoryTest extends TestCase
{

    /**
     * @throws GeneralException
     * @throws MappingException
     * @throws ReflectionException
     */
    public function testCreate()
    {
        $em = $this->getEntityManager();

        $mapper = new AnnotationMapper($em);

        $query = QueryFactory::create($mapper);

        $this->assertInstanceOf(ObjectType::class, $query);

        $expected = [
            'Category'
        ];
        $this->assertEquals($expected, array_keys($query->getFields()));
    }
}
