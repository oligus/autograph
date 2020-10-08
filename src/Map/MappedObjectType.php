<?php declare(strict_types=1);

namespace Autograph\Map;

use Autograph\Map\Annotations\ObjectField;
use Autograph\Map\Annotations\ObjectType;
use Autograph\Map\Enums\QueryType;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\MappingException;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Exception;

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
                $this->fields[] = new MappedObjectField($property, $reflectionProperty, $meta->getFieldMapping($reflectionProperty->name));
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

    public function getQueryType(): QueryType
    {
        $value = strtoupper($this->objectType->queryType ?? QueryType::NONE);
        $type = QueryType::NONE();

        try {
            $type = QueryType::$value();
            // @phan-suppress-next-line PhanUnusedVariableCaughtException
        } catch (Exception $e) {
        }

        return $type;
    }

    public function getQueryField(): string
    {
        if (isset($this->objectType->queryField) && is_string($this->objectType->queryField)) {
            return (string) $this->objectType->queryField;
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
}
