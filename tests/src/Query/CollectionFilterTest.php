<?php declare(strict_types=1);

namespace Tests\Query;

use Autograph\Demo\Database\Entities\Albums;
use Autograph\Helpers\ClassHelper;
use Autograph\Query\Arguments;
use Autograph\Query\CollectionFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Tests\TestCase;
use ReflectionException;

/**
 * Class CollectionFilterTest
 * @package Tests\Query
 */
class CollectionFilterTest extends TestCase
{

    /**
     * @throws ReflectionException
     */
    public function testCreate()
    {
        $collection = new ArrayCollection();

        $a = new Albums();
        ClassHelper::setPropertyValue($a, 'id', 1);
        ClassHelper::setPropertyValue($a, 'title', 'Test title 1');
        $collection->add($a);

        $a = new Albums();
        ClassHelper::setPropertyValue($a, 'id', 2);
        ClassHelper::setPropertyValue($a, 'title', 'Test title 2');
        $collection->add($a);

        $a = new Albums();
        ClassHelper::setPropertyValue($a, 'id', 3);
        ClassHelper::setPropertyValue($a, 'title', 'Test title 3');
        $collection->add($a);

        $a = new Albums();
        ClassHelper::setPropertyValue($a, 'id', 4);
        ClassHelper::setPropertyValue($a, 'title', 'Title 4');
        $collection->add($a);

        $a = new Albums();
        ClassHelper::setPropertyValue($a, 'id', 5);
        ClassHelper::setPropertyValue($a, 'title', 'Test title 5');
        $collection->add($a);

        $a = new Albums();
        ClassHelper::setPropertyValue($a, 'id', 6);
        ClassHelper::setPropertyValue($a, 'title', 'Test title 6');
        $collection->add($a);

        $args =[
            "first" => 2,
            "after" => 2,
            "filter" => [
                "title" => "Test"
            ]
        ];

        $arguments = new Arguments($args);

        $filter = new CollectionFilter($collection, $arguments);

        $this->assertEquals(6, $filter->getTotalCount());
        $this->assertEquals(2, $filter->getCount());

        $filteredCollection = $filter->getFilteredCollection();
        $this->assertEquals(2, $filteredCollection->count());

        $this->assertEquals(3, $filteredCollection->get(0)->getId());
        $this->assertEquals('Test title 3', $filteredCollection->get(0)->getTitle());

        $this->assertEquals(5, $filteredCollection->get(1)->getId());
        $this->assertEquals('Test title 5', $filteredCollection->get(1)->getTitle());
    }
}
