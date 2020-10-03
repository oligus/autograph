<?php declare(strict_types=1);

namespace Autograph\Map;

use GraphQL\Type\Definition\ObjectType;

/**
 * Class ObjectFactory
 * @package Autograph\Map
 */
class ObjectFactory
{
    public static function create(MappedObjectType $objectType): ObjectType
    {
        $config = [];
        $config['name'] = $objectType->getName();
        $config['description'] = $objectType->getDescription();
        $config['fields'] = $objectType->getFields();

        return new ObjectType($config);
    }
}
