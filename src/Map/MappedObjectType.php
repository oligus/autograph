<?php declare(strict_types=1);

namespace Autograph\Map;

use Autograph\GraphQL\Types\Filter;
use Autograph\Map\Annotations\ObjectField;
use Autograph\Map\Annotations\ObjectType;
use Autograph\Map\Enums\QueryMethod;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\MappingException;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Exception;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class ObjectType
 * @package Autograph\Map
 */
class MappedObjectType
{
    private ObjectType $objectType;

    private ClassMetadata $meta;

    /**
     * @var array<MappedObjectField>
     */
    private array $fields = [];

    /**
     * @throws MappingException
     */
    public function __construct(ObjectType $objectType, ClassMetadataInfo $meta)
    {
        $this->objectType = $objectType;
        $this->meta = $meta;

        $reader = new AnnotationReader();

        foreach ($meta->getReflectionClass()->getProperties() as $reflectionProperty) {
            $property = $reader->getPropertyAnnotation($reflectionProperty, ObjectField::class);

            if ($property instanceof ObjectField) {
                $objectField = new MappedObjectField($property, $reflectionProperty);

                if ($meta->hasField($reflectionProperty->name)) {
                    $objectField->setFieldMapping($meta->getFieldMapping($reflectionProperty->name));
                } elseif ($meta->hasAssociation($reflectionProperty->name)) {
                    $objectField->setAssociationMapping($meta->getAssociationMapping($reflectionProperty->name));
                }

                $this->fields[] = $objectField;
            }
        }
    }

    public function getName(): string
    {
        if (isset($this->objectType->name)) {
            return $this->objectType->name ?? 'undefined';
        }

        return $this->meta->getReflectionClass()->getShortName();
    }

    public function getDescription(): ?string
    {
        if (isset($this->objectType->description)) {
            return $this->objectType->description;
        }

        return null;
    }

    public function getClassName(): string
    {
        return $this->meta->getReflectionClass()->name;
    }

    public function getQueryMethod(): QueryMethod
    {
        $value = strtoupper($this->objectType->query['method'] ?? QueryMethod::NONE);
        $method = QueryMethod::NONE();

        try {
            $method = QueryMethod::$value();
            // @phan-suppress-next-line PhanUnusedVariableCaughtException
        } catch (Exception $e) {
        }

        return $method;
    }

    public function getQueryFieldName(): string
    {
        if (isset($this->objectType->query['fieldName']) && is_string($this->objectType->query['fieldName'])) {
            return (string) $this->objectType->query['fieldName'];
        }

        return $this->getName();
    }

    /**
     * @return array<mixed>
     */
    public function getFields(): array
    {
        $result = [];

        /** @var MappedObjectField $field */
        foreach ($this->fields as $field) {
            $result = array_merge($result, $field->getField());
        }

        return $result;
    }

    /**
     * @return MappedObjectField[]
     */
    public function getMappedFields(): array
    {
        return $this->fields;
    }

    /**
     * @return InputObjectType[]|null
     */
    public function createFilter(): ?array
    {
        $filteredFields = $this->objectType->query['filter'] ?? [];
        $fields = $this->getMappedFields();

        return Filter::create($this->getName(), $fields, $filteredFields);
    }
}
