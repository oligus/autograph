<?php declare(strict_types=1);

namespace Autograph\GraphQL\Types;

use Autograph\GraphQL\EntityResolver;
use Autograph\GraphQL\Resolvers\EntityList;
use Autograph\GraphQL\TypeManager;
use Autograph\Map\AnnotationMapper;
use Autograph\Map\Enums\QueryMethod;
use Autograph\Map\MappedObjectType;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class Query
 * @package Autograph\GraphQL\Types
 */
class Query
{
    public static function create(AnnotationMapper $mapper): ObjectType
    {
        $fields = [];

        /** @var MappedObjectType $objectType */
        foreach ($mapper->getObjectMap() as $objectType) {
            $resolver = new EntityResolver($objectType);

            switch ($objectType->getQueryMethod()) {
                case QueryMethod::SINGLE():
                    $fields[$objectType->getQueryFieldName()] = [
                        'type' => TypeManager::get($objectType->getName()),
                        'args' => ['id' => TypeManager::nonNull(TypeManager::id())],
                        'resolve' => $resolver->resolve()
                    ];
                    break;
                case QueryMethod::LIST():
                    $resolver = new EntityList($objectType);
                    $listField = $resolver->getField();
                    $fields = array_merge($fields, $listField);
                    break;

                default:
            }
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
