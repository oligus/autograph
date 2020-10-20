<?php declare(strict_types=1);

namespace Autograph\GraphQL\Types;

use Autograph\GraphQL\Resolvers\EntityList;
use Autograph\GraphQL\Resolvers\Single;
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
            switch ($objectType->getQueryMethod()) {
                case QueryMethod::SINGLE():
                    $resolver = new Single($objectType);
                    $singleField = $resolver->getField();
                    $fields = array_merge($fields, $singleField);
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
