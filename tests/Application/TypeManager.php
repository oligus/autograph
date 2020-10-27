<?php declare(strict_types=1);

namespace Autograph\Tests\Application;

use Autograph\Tests\Application\Schema\Types\Query;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class TypeManager
 * @package Autograph\Tests\Application
 */
class TypeManager
{
    /**
     * @var array $types
     */
    private static $types = [];

    /**
     * @var array $types
     */
    private static $inputTypes = [];

    /**
     * @return Query|mixed
     */
    public static function query()
    {
        if (array_key_exists('query', self::$types)) {
            return self::$types['query'];
        }

        self::$types['query'] = new Query();

        return self::$types['query'];
    }

    /**
     * @param $typeName
     * @return ObjectType
     */
    public static function get($typeName): ObjectType
    {
        if (array_key_exists($typeName, self::$types)) {
            return self::$types[$typeName];
        }

        $field = 'Autograph\Tests\Application\Schema\Types\\' . ucfirst($typeName);
        self::$types[$typeName] = new $field;

        return self::$types[$typeName];
    }

    /**
     * @param $typeName
     * @return InputObjectType
     */
    public static function getInput($typeName): InputObjectType
    {
        if (array_key_exists($typeName, self::$types)) {
            return self::$inputTypes[$typeName];
        }

        $inputType = 'Server\Schema\Types\Inputs\\' . ucfirst($typeName);

        self::$inputTypes[$typeName] = new $inputType;

        return self::$inputTypes[$typeName];
    }

    /**
     * @return ScalarType
     */
    public static function boolean()
    {
        return Type::boolean();
    }

    /**
     * @return ScalarType
     */
    public static function float()
    {
        return Type::float();
    }

    /**
     * @return ScalarType
     */
    public static function id()
    {
        return Type::id();
    }

    /**
     * @return ScalarType
     */
    public static function int()
    {
        return Type::int();
    }

    /**
     * @return ScalarType
     */
    public static function string()
    {
        return Type::string();
    }

    /**
     * @param Type $type
     * @return ListOfType
     */
    public static function listOf($type)
    {
        return new ListOfType($type);
    }

    /**
     * @param $type
     * @return NonNull
     * @throws \Exception
     */
    public static function nonNull($type)
    {
        return new NonNull($type);
    }
}
