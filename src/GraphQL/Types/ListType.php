<?php declare(strict_types=1);

namespace Autograph\GraphQL\Types;

use Autograph\GraphQL\TypeManager;
use Exception;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

/**
 * Class ListType
 * @package Autograph\GraphQL\Types
 */
class ListType
{
    public static function create(string $fieldName, Type $type): ObjectType
    {
        $config = [
            'name' => ucfirst($fieldName),
            /**
             * @return array<mixed>
             * @throws Exception
             */
            'fields' => function () use ($type) : array {
                return [
                    'totalCount' => TypeManager::int(),
                    'nodes' => TypeManager::listOf($type)
                ];
            }
        ];

        return new ObjectType($config);
    }
}
