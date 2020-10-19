<?php declare(strict_types=1);

namespace Autograph\GraphQL;

use GraphQL\Type\Definition;

/**
 * Class TypeManager
 * @package Autograph\GraphQL
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class TypeManager
{
    /**
     * @var array<Definition\Type>
     */
    private static array $types = [];

    public static function get(string $typeName): Definition\Type
    {
        if (!array_key_exists($typeName, self::$types)) {
            self::$types[$typeName] = self::{$typeName}();
        }

        return self::$types[$typeName];
    }

    public static function add(Definition\Type $type): void
    {
        if (!array_key_exists($type->name, self::$types)) {
            self::$types[$type->name] = $type;
        }
    }

    public static function exists(string $typeName): bool
    {
        if (array_key_exists($typeName, self::$types)) {
            return true;
        }

        if (method_exists(self::class, $typeName)) {
            return true;
        }

        return false;
    }

    public static function clear(): void
    {
        self::$types = [];
    }

    public static function boolean(): Definition\ScalarType
    {
        return Definition\Type::boolean();
    }

    public static function float(): Definition\ScalarType
    {
        return Definition\Type::float();
    }

    public static function id(): Definition\ScalarType
    {
        return Definition\Type::id();
    }

    public static function int(): Definition\ScalarType
    {
        return Definition\Type::int();
    }

    public static function integer(): Definition\ScalarType
    {
        return Definition\Type::int();
    }

    public static function string(): Definition\ScalarType
    {
        return Definition\Type::string();
    }

    public static function listOf(Definition\Type $type): Definition\ListOfType
    {
        return new Definition\ListOfType($type);
    }

    public static function nonNull(Definition\Type $type): Definition\NonNull
    {
        return new Definition\NonNull($type);
    }
}
