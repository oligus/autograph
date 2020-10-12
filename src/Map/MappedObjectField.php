<?php declare(strict_types=1);

namespace Autograph\Map;

use Autograph\Doctrine\TypeConversion;
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

    /**
     * @var array<string>
     */
    private array $fieldMapping;

    private TypeConversion $conversion;

    /**
     * @param array<string> $fieldMapping
     */
    public function __construct(ObjectField $objectField, ReflectionProperty $reflectionProperty, array $fieldMapping)
    {
        $this->objectField = $objectField;
        $this->reflectionProperty = $reflectionProperty;
        $this->fieldMapping = $fieldMapping;
        $this->conversion = new TypeConversion($this->fieldMapping);
    }

    public function getName(): ?string
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
            $inType = $this->objectField->type ?? 'string';

            if (strpos($inType, '!')) {
                $inType = trim($inType, '!');
                return TypeManager::nonNull(TypeManager::get($inType));
            }

            return TypeManager::get($inType);
        }

        if (!$this->conversion->isNullable()) {
            return TypeManager::nonNull($this->conversion->getType());
        }

        return $this->conversion->getType();
    }

    public function isFilterable(): bool
    {
        return $this->objectField->filterable ?? false;
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
