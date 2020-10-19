<?php declare(strict_types=1);

namespace Autograph\GraphQL\Types;

use Autograph\GraphQL\TypeManager;
use Autograph\Map\MappedObjectField;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\NonNull;

/**
 * Class Filter
 * @package Autograph\GraphQL\Types
 */
class Filter
{
    /**
     * @param string $name
     * @param array<MappedObjectField> $fields
     * @param array<string> $filteredFields
     * @return InputObjectType[]|null
     */
    public static function create(string $name, array $fields, array $filteredFields): ?array
    {
        $filterFields = [];

        /** @var MappedObjectField $field */
        foreach ($fields as $field) {
            if (!in_array($field->getName(), $filteredFields)) {
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

        $filterName = $name . 'Filter';

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
