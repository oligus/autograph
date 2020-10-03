<?php declare(strict_types=1);

namespace Autograph\Map;

use Autograph\GraphQL\TypeManager;
use Autograph\Map\Annotations\ObjectType;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\MappingException;

/**
 * Class AnnotationMapper
 * @package Autograph\Map
 */
class AnnotationMapper
{
    /**
     * @var array<MappedObjectType>
     */
    private array $objectMap = [];

    /**
     * @throws MappingException
     */
    public function __construct(EntityManagerInterface $em)
    {
        $reader = new AnnotationReader();
        $metaData = $em->getMetadataFactory()->getAllMetadata();

        foreach ($metaData as $meta) {
            $object = $reader->getClassAnnotation($meta->getReflectionClass(), ObjectType::class);

            if ($object instanceof ObjectType && $meta instanceof ClassMetadataInfo) {
                $objectType = new MappedObjectType($object, $meta);
                $this->objectMap[] = $objectType;
                TypeManager::add(ObjectFactory::create($objectType));
            }
        }
    }

    /**
     * @return array<MappedObjectType>
     */
    public function getObjectMap(): array
    {
        return $this->objectMap;
    }
}
