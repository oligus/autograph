<?php declare(strict_types=1);

namespace Autograph\Helpers;

use ReflectionClass;
use ReflectionException;
use ReflectionClassConstant;
use Exception;

/**
 * Class ClassHelper
 * @package Autograph\Helpers
 */
class ClassHelper
{
    /**
     * @return mixed
     * @throws ReflectionException
     * @throws Exception
     */
    public static function getPropertyValue(object $class, string $property)
    {
        $method = 'get' . ucfirst($property);

        if (method_exists($class, $method)) {
            return $class->$method();
        }

        $reflection = new ReflectionClass($class);

        if ($reflection->hasProperty($property)) {
            $reflectionProperty = $reflection->getProperty($property);
            $reflectionProperty->setAccessible(true);
            return $reflectionProperty->getValue($class);
        }

        throw new Exception('Property [' . $property . '] not found in class [' . get_class($class) . ']');
    }

    /**
     * @param mixed $value
     * @throws ReflectionException
     */
    public static function setPropertyValue(object $class, string $property, $value): void
    {
        $method = 'set' . ucfirst($property);

        if (method_exists($class, $method)) {
            $class->$method($value);
            return;
        }

        $reflection = new ReflectionClass($class);

        if ($reflection->hasProperty($property)) {
            $reflectionProperty = $reflection->getProperty($property);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($class, $value);
        }
    }

    /**
     * @throws ReflectionException
     */
    public static function hasPropertyValue(object $class, string $property): bool
    {
        $method = 'set' . ucfirst($property);

        if (method_exists($class, $method)) {
            return true;
        }

        $reflection = new ReflectionClass($class);

        return $reflection->hasProperty($property);
    }

    /**
     * @return mixed|null
     * @phan-suppress PhanUnusedVariableCaughtException
     */
    public static function getClassConstantValue(object $class, string $constant)
    {
        try {
            $classConstant = new ReflectionClassConstant($class, $constant);
            $constantValue = $classConstant->getValue();
        } catch (Exception $e) {
            $constantValue = null;
        }

        return $constantValue;
    }

    /**
     * @return array<mixed>|null
     */
    public static function getCaller(int $depth = 1): ?array
    {
        try {
            throw new Exception;
        } catch (Exception $e) {
            return $e->getTrace()[$depth] ?? null;
        }
    }
}
