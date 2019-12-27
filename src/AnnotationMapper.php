<?php declare(strict_types=1);

namespace Autograph;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Annotations\AnnotationException;

/**
 * Class AnnotationMapper
 * @package Autograph
 */
class AnnotationMapper
{
    /**
     * AnnotationMapper constructor.
     * @param EntityManagerInterface $em
     * @throws AnnotationException
     */
    public function __construct(EntityManagerInterface $em)
    {
        AnnotationReader::addGlobalIgnoredName('phan');

        $reader = new AnnotationReader();
        $metaData = $em->getMetadataFactory()->getAllMetadata();

        /** @var ClassMetadata $meta */
        foreach ($metaData as $meta) {
            //dump($meta);
            /*
            $type = $reader->getClassAnnotation($meta->getReflectionClass(), Annotations\Type::class);

            if (!empty($type)) {
                $name = $type->name;
                $pluralized = $inflector->pluralize($name);

                $this->rootFields[lcfirst($name)] = call_user_func('CX\Schema\Fields\\' . $name . '::getField');
                $this->rootFields[lcfirst($pluralized)] = call_user_func('CX\Schema\Fields\\' . $pluralized . '::getField');
            }
        }

        $this->rootFields['priceItem'] = call_user_func('CX\Schema\Fields\PriceItem::getField');
        $this->rootFields['priceItems'] = call_user_func('CX\Schema\Fields\PriceItems::getField');
        $this->rootFields['ado'] = call_user_func('CX\Schema\Fields\Ado::getField');
        $this->rootFields['ados'] = call_user_func('CX\Schema\Fields\Ados::getField');
            */
        }

    }
}
