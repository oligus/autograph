<?php declare(strict_types=1);

namespace Autograph\Tests\Map;

use Autograph\Map\Annotations\ObjectField;
use Autograph\Map\MappedObjectField;
use Autograph\Tests\Application\Entities\Categories;
use GraphQL\Type\Definition\IDType;
use GraphQL\Type\Definition\IntType;
use GraphQL\Type\Definition\StringType;
use ReflectionProperty;
use Tests\TestCase;

class MappedObjectFieldTest extends TestCase
{
    public function testConstruct()
    {
        $objectField = new ObjectField();
        $objectField->name = 'message';
        $objectField->type = 'String';
        $objectField->description = 'A description of name';

        $reflectionProperty = $this->getMockBuilder(ReflectionProperty::class)
            ->disableOriginalConstructor()
            ->getMock();

        $field = new MappedObjectField($objectField, $reflectionProperty, []);

        $result = $field->getField();

        $this->assertEquals('message', $result['message']['name']);
        $this->assertEquals('A description of name', $result['message']['description']);
        $this->assertInstanceOf(StringType::class, $result['message']['type']);
    }

    public function testGetName()
    {
        $objectField = new ObjectField();
        $property = new ReflectionProperty(Categories::class, 'id');
        $field = new MappedObjectField($objectField, $property, []);
        $this->assertEquals('id', $field->getName());

        $objectField->name = 'identity';
        $field = new MappedObjectField($objectField, $property, []);
        $this->assertEquals('identity', $field->getName());
    }

    public function testGetDescription()
    {
        $objectField = new ObjectField();
        $property = new ReflectionProperty(Categories::class, 'id');
        $field = new MappedObjectField($objectField, $property, []);
        $this->assertNull($field->getDescription());

        $objectField->description = 'A test';
        $field = new MappedObjectField($objectField, $property, []);
        $this->assertEquals('A test', $field->getDescription());
    }

    public function testGetType()
    {
        $objectField = new ObjectField();
        $property = new ReflectionProperty(Categories::class, 'id');
        $field = new MappedObjectField($objectField, $property, ["type" => "integer"]);
        $this->assertInstanceOf(IntType::class, $field->getType());
        $field = new MappedObjectField($objectField, $property, ["type" => "string"]);
        $this->assertInstanceOf(StringType::class, $field->getType());
        $field = new MappedObjectField($objectField, $property, ["type" => "integer", "id" => true]);
        $this->assertInstanceOf(IDType::class, $field->getType());
    }
}
