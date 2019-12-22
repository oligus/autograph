<?php

namespace Tests\Helpers;

use Autograph\Helpers\ClassHelper;
use Tests\TestCase;
use Exception;
use ReflectionException;

/**
 * Class ClassHelperTest
 * @package Tests\Helpers
 */
class ClassHelperTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testGetPropertyValue()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Property [property3] not found in class [Tests\Helpers\TestClass]');

        $class = new TestClass();
        ClassHelper::setPropertyValue($class, 'property1', 'test');

        $this->assertEquals('test', ClassHelper::getPropertyValue($class, 'property1'));
        $this->assertEquals('prop2', ClassHelper::getPropertyValue($class, 'property2'));
        $this->expectException(ClassHelper::getPropertyValue($class, 'property3'));
    }

    /**
     * @throws \Exception
     */
    public function testSetPropertyValue()
    {
        $class = new TestClass();
        ClassHelper::setPropertyValue($class, 'property1', 'test');
        $this->assertEquals('test', ClassHelper::getPropertyValue($class, 'property1'));

        ClassHelper::setPropertyValue($class, 'property2', 'test2');
        $this->assertEquals('test', ClassHelper::getPropertyValue($class, 'property1'));
    }

    /**
     * @throws ReflectionException
     */
    public function testHasPropertyValue()
    {
        $class = new TestClass();
        $this->assertFalse(ClassHelper::hasPropertyValue($class, 'testProperty'));
        $this->assertTrue(ClassHelper::hasPropertyValue($class, 'property1'));
        $this->assertTrue(ClassHelper::hasPropertyValue($class, 'property2'));
    }

}

class TestClass
{
    public $property1;

    public $property2;

    // public $property3 = 'Test';

    public function getProperty2()
    {
        return 'prop2';
    }

    public function setProperty2($value)
    {
        $this->property2 = $value;
    }
}
