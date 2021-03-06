<?php declare(strict_types=1);

namespace Autograph\Tests\Map;

use Autograph\Map\Annotations\ObjectField;
use Autograph\Map\MappedObjectField;
use Autograph\Tests\Application\Entities\Album;
use GraphQL\Type\Definition\IDType;
use GraphQL\Type\Definition\IntType;
use GraphQL\Type\Definition\NonNull;
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

        /** @var ReflectionProperty $reflectionProperty */
        $reflectionProperty = $this->getMockBuilder(ReflectionProperty::class)
            ->disableOriginalConstructor()
            ->getMock();

        $field = new MappedObjectField($objectField, $reflectionProperty);

        $result = $field->getField();

        $this->assertEquals('message', $result['message']['name']);
        $this->assertEquals('A description of name', $result['message']['description']);
        $this->assertInstanceOf(StringType::class, $result['message']['type']);
    }

    public function testGetName()
    {
        $objectField = new ObjectField();
        $property = new ReflectionProperty(Album::class, 'id');
        $field = new MappedObjectField($objectField, $property);
        $this->assertEquals('id', $field->getName());

        $field = new MappedObjectField($objectField, $property);
        $field->setFieldMapping(['fieldName' => 'testField']);
        $this->assertEquals('testField', $field->getName());

        $objectField->name = 'identity';
        $field = new MappedObjectField($objectField, $property);
        $this->assertEquals('identity', $field->getName());
    }

    public function testGetDescription()
    {
        $objectField = new ObjectField();
        $property = new ReflectionProperty(Album::class, 'id');
        $field = new MappedObjectField($objectField, $property);
        $this->assertNull($field->getDescription());

        $objectField->description = 'A test';
        $field = new MappedObjectField($objectField, $property);
        $this->assertEquals('A test', $field->getDescription());
    }

    public function testGetType()
    {
        $objectField = new ObjectField();
        $property = new ReflectionProperty(Album::class, 'id');
        $field = new MappedObjectField($objectField, $property);
        $field->setFieldMapping(["type" => "integer"]);
        $this->assertInstanceOf(NonNull::class, $field->getType());
        $this->assertInstanceOf(IntType::class, $field->getType()->getOfType());

        $field = new MappedObjectField($objectField, $property);
        $field->setFieldMapping(["type" => "string"]);
        $this->assertInstanceOf(NonNull::class, $field->getType());
        $this->assertInstanceOf(StringType::class, $field->getType()->getOfType());

        $field = new MappedObjectField($objectField, $property);
        $field->setFieldMapping(["type" => "integer", "id" => true]);
        $this->assertInstanceOf(NonNull::class, $field->getType());
        $this->assertInstanceOf(IDType::class, $field->getType()->getOfType());

        $property = new ReflectionProperty(Album::class, 'title');
        $objectField->type = 'String!';
        $field = new MappedObjectField($objectField, $property, []);
        $this->assertInstanceOf(NonNull::class, $field->getType());
        $this->assertInstanceOf(StringType::class, $field->getType()->getOfType());
    }
}
