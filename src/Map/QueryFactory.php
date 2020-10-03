<?php declare(strict_types=1);

namespace Autograph\Map;

use Autograph\GraphQL\EntityResolver;
use Autograph\GraphQL\TypeManager;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class QueryFactory
 * @package Autograph\Map
 */
class QueryFactory
{
    public static function create(AnnotationMapper $mapper): ObjectType
    {
        $fields = [];

        /** @var MappedObjectType $objectType */
        foreach ($mapper->getObjectMap() as $objectType) {
            $resolver = new EntityResolver($objectType);

            $fields[$objectType->getName()] = [
                'type' => TypeManager::get($objectType->getName()),
                'args' => ['id' => TypeManager::nonNull(TypeManager::id())],
                'resolve' => $resolver->resolve()
            ];
        }

        $config = [
            'name' => 'Query',
            'description' => 'Stimplify Query fields',

            /**
             * @return array<mixed>
             */
            'fields' => function () use ($fields): array {
                return $fields;
            }
        ];

        return new ObjectType($config);
    }
}
