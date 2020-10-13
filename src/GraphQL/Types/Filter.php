<?php declare(strict_types=1);

namespace Autograph\GraphQL\Types;

use Autograph\GraphQL\TypeManager;
use Autograph\Map\MappedObjectType;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\NonNull;

/**
 * Class Filter
 * @package Autograph\GraphQL\Types
 */
class Filter
{
    /**
     * @return InputObjectType[]|null
     */
    public static function create(MappedObjectType $objectType): ?array
    {
        $filterFields = [];

        foreach ($objectType->getMappedFields() as $field) {
            if (!$field->isFilterable()) {
                continue;
            }

            $type = $field->getType();

            if ($type instanceof NonNull) {
                $type = $type->getOfType();
            }

            $filterFields[$field->getName()] = [
                'type' => $type
            ];
        }

        if (empty($filterFields)) {
            return null;
        }

        $filterName = $objectType->getName() . 'Filter';

        $filterType = new InputObjectType([
            'name' => $filterName,
            'fields' => $filterFields
        ]);

        TypeManager::add($filterType);

        return [
            'type' => $filterType,
        ];
    }
}
