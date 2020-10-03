<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Autograph\Helpers\ClassHelper;
use ReflectionException;
use Tests\TestCase;

/**
 * Class CategoriesTest
 * @package Autograph\Tests\Application\Entities
 */
class CategoriesTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testEntity()
    {
        $em = $this->getEntityManager();
        $category = $em->getRepository(Categories::class)->find(1);

        $this->assertEquals('Beverages', ClassHelper::getPropertyValue($category, 'name'));
        $this->assertEquals('Soft drinks, coffees, teas, beers, and ales', ClassHelper::getPropertyValue($category, 'description'));
    }
}