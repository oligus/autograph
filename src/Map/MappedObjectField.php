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
     * @var array|null
     */
    private ?array $fieldMapping = null;

    /**
     * @var array|null
     */
    private ?array $associationMapping = null;

    public function __construct(ObjectField $objectField, ReflectionProperty $reflectionProperty)
    {
        $this->objectField = $objectField;
        $this->reflectionProperty = $reflectionProperty;
    }

    public function setFieldMapping(array $fieldMapping): void
    {
        $this->fieldMapping = $fieldMapping;
    }

    public function setAssociationMapping(array $associationMapping): void
    {
        $this->associationMapping = $associationMapping;
    }

    public function isAssociation(): bool
    {
        return !empty($this->associationMapping);
    }

    public function getName(): string
    {
        if (isset($this->objectField->name)) {
            return (string) $this->objectField->name;
        }

        if (is_array($this->fieldMapping) && array_key_exists('fieldName', $this->fieldMapping)) {
            return  $this->fieldMapping['fieldName'];
        }

        if (is_array($this->associationMapping) && array_key_exists('fieldName', $this->associationMapping)) {
            return  $this->associationMapping['fieldName'];
        }

        return $this->reflectionProperty->name ?? 'unknown';
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

        if (!$this->isAssociation()) {
            $conversion = new TypeConversion($this->fieldMapping);
            if (!$conversion->isNullable()) {
                return TypeManager::nonNull($conversion->getType());
            }

            return $conversion->getType();
        }

        return TypeManager::get($this->associationMapping['fieldName']);
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
