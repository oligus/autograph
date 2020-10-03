<?php declare(strict_types=1);

namespace Autograph\Map;

use Autograph\GraphQL\TypeManager;
use Autograph\Map\Annotations\ObjectType;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;

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

    public function __construct(EntityManagerInterface $em)
    {
        $reader = new AnnotationReader();
        $metaData = $em->getMetadataFactory()->getAllMetadata();

        foreach ($metaData as $meta) {
            $object = $reader->getClassAnnotation($meta->getReflectionClass(), ObjectType::class);

            if ($object instanceof ObjectType) {
                $objectType = new MappedObjectType($object, $meta);
                $this->objectMap[] = $objectType;
                TypeManager::add(ObjectFactory::create($objectType));
            }
        }
    }

    public function getObjectMap(): array
    {
        return $this->objectMap;
    }
}
