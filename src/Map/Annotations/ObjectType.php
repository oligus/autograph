<?php declare(strict_types=1);

namespace Autograph\Map\Annotations;

use Doctrine\ORM\Mapping\Annotation;

/**
 * Class ObjectType
 * @package Autograph\Map\Annotations
 *
 * @Annotation
 * @Target("CLASS")
 */
final class ObjectType implements Annotation
{
    public ?string $name;

    public ?string $description;

    public array $query = [];
}
