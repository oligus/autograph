<?php declare(strict_types=1);

namespace Autograph\Demo\Schema;

use Autograph\Demo\Schema\Types\Query;
use GraphQL\Type\Definition;
use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\NonNull;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\InputObjectType;
use Exception;

/**
 * Class TypeManager
 * @package Autograph\Demo\Schema
 */
class TypeManager
{
    const CLASSPATH = 'Autograph\Demo\Schema\Types';

    /**
     * @var array<string,mixed>
     */
    private static array $types = [];

    /**
     * @var array<string,InputObjectType>
     */
    private static array $inputTypes = [];

    /**
     * @var array<string,Definition\InterfaceType>
     */
    private static array $interfaceTypes = [];

    /**
     * @var array<string,ScalarType>
     */
    private static array $scalarTypes = [];

    /**
     * @var array<string,Definition\UnionType>
     */
    private static array $unionTypes = [];

    /**
     * @throws Exception
     */
    public static function query(): Query
    {
        if (array_key_exists('query', self::$types)) {
            return self::$types['query'];
        }

        self::$types['query'] = new Query();

        return self::$types['query'];
    }

    public static function get(string $typeName): ObjectType
    {
        if (array_key_exists($typeName, self::$types)) {
            return self::$types[$typeName];
        }

        $field = self::CLASSPATH . '\\' . ucfirst($typeName);
        self::$types[$typeName] = new $field;

        return self::$types[$typeName];
    }

    public static function getInput(string $typeName): InputObjectType
    {
        if (array_key_exists($typeName, self::$inputTypes)) {
            return self::$inputTypes[$typeName];
        }

        $inputType = self::CLASSPATH . '\\' . 'Input\\' . ucfirst($typeName);

        self::$inputTypes[$typeName] = new $inputType;

        return self::$inputTypes[$typeName];
    }

    public static function getInterface(string $typeName): Definition\InterfaceType
    {
        if (array_key_exists($typeName, self::$interfaceTypes)) {
            return self::$interfaceTypes[$typeName];
        }

        $interfaceType = self::CLASSPATH . '\\' . 'Interfaces\\' . ucfirst($typeName);

        self::$interfaceTypes[$typeName] = new $interfaceType;

        return self::$interfaceTypes[$typeName];
    }

    public static function getScalar(string $typeName): ScalarType
    {
        if (array_key_exists($typeName, self::$scalarTypes)) {
            return self::$scalarTypes[$typeName];
        }

        $scalarType = self::CLASSPATH . '\\' . 'Scalars\\' . ucfirst($typeName) . 'Type';

        self::$scalarTypes[$typeName] = new $scalarType;

        return self::$scalarTypes[$typeName];
    }

    public static function boolean(): Definition\BooleanType
    {
        return Type::boolean();
    }

    public static function float(): Definition\FloatType
    {
        return Type::float();
    }

    public static function id(): Definition\IDType
    {
        return Type::id();
    }

    public static function int(): Definition\IntType
    {
        return Type::int();
    }

    public static function string(): Definition\StringType
    {
        return Type::string();
    }

    public static function listOf(Type $type): ListOfType
    {
        return new ListOfType($type);
    }

    /**
     * @param mixed $type
     * @throws Exception
     */
    public static function nonNull($type): NonNull
    {
        return new NonNull($type);
    }

    public static function date(): ScalarType
    {
        if (array_key_exists('date', self::$scalarTypes)) {
            return self::$scalarTypes['date'];
        }

        self::$scalarTypes['date'] = new DateType();

        return self::$scalarTypes['date'];
    }

    public static function datetime(): ScalarType
    {
        if (array_key_exists('datetime', self::$scalarTypes)) {
            return self::$scalarTypes['datetime'];
        }

        self::$scalarTypes['datetime'] = new DateTimeType();

        return self::$scalarTypes['datetime'];
    }

    public static function uuid(): ScalarType
    {
        if (array_key_exists('uuid', self::$scalarTypes)) {
            return self::$scalarTypes['uuid'];
        }

        self::$scalarTypes['uuid'] = new Uuid();

        return self::$scalarTypes['uuid'];
    }

    /**
     * @param array<mixed> $types
     * @throws Exception
     */
    public static function union(array $types): Definition\UnionType
    {
        $inTypes = [];

        foreach ($types as $type) {
            if (is_array($type) && array_key_exists('type', $type)) {
                $inTypes[] = $type['type'];
                continue;
            } elseif ($type instanceof Type) {
                $inTypes[] = $type;
                continue;
            }
        }

        $key = '';

        foreach ($inTypes as $type) {
            $key .= $type->name;
        }

        $key .= 'Union';

        if (array_key_exists($key, self::$unionTypes)) {
            return self::$unionTypes[$key];
        }

        $union = new Definition\UnionType([
            'name' => $key,
            'types' => $inTypes,

            /**
             * @param array<string,mixed> $result
             * @throws Exception
             */
            'resolveType' => function (array $result) use ($inTypes) : object {
                /** @var Type $type */
                foreach ($inTypes as $type) {
                    $typeName = $type->name;

                    $resultName = '';

                    if (is_array($result) && array_key_exists('__type', $result)) {
                        $resultName = $result['__type'];
                    } elseif (is_object($result)) {
                        $resultName = preg_replace('/.+?\\\/', '', get_class($result));
                    }

                    if ($typeName === $resultName) {
                        return $type;
                    }
                }

                throw new Exception('Could not match class to type.');
            }
        ]);

        self::$unionTypes[$key] = $union;

        return self::$unionTypes[$key];
    }
}
