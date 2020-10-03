<?php declare(strict_types=1);

namespace Autograph\Map;

use Autograph\GraphQL\TypeManager;
use Autograph\Map\Annotations\ObjectField;
use GraphQL\Type\Definition\Type;
use ReflectionProperty;

/**
 * Class MappedObjectField
 * @package Autograph\Map
 */
class MappedObjectField
{
    private ObjectField $objectField;
    private ReflectionProperty $reflectionProperty;
    private array $fieldMapping;

    /**
     * @param array $fieldMapping
     */
    public function __construct(ObjectField $objectField, ReflectionProperty $reflectionProperty, array $fieldMapping)
    {
        $this->objectField = $objectField;
        $this->reflectionProperty = $reflectionProperty;
        $this->fieldMapping = $fieldMapping;
    }

    public function getName(): string
    {
        if (isset($this->objectField->name)) {
            return $this->objectField->name;
        }

        return $this->reflectionProperty->name;
    }

    public function getDescription(): ?string
    {
        if (isset($this->objectField->description)) {
            return $this->objectField->description;
        }

        return null;
    }

    public function getType(): Type
    {
        if (isset($this->objectField->type)) {
            $inType = $this->objectField->type;
        } else {
            $inType = $this->fieldMapping['type'];
        }

        if ($this->fieldMapping['id'] ?? false) {
            $inType = 'ID';
        }

        return TypeManager::get($inType);
    }


    /**
     * @return array<mixed>
     */
    public function getField(): array
    {
        return [
            $this->getName() => [
                'name' => $this->getName(),
                'description' => $this->getDescription(),
                'type' => $this->getType(),
                'deprecationReason' => $this->objectField->deprecationReason,
                'resolveFn' => $this->objectField->resolveFn,
            ]
        ];
    }
}
