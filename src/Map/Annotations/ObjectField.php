<?php declare(strict_types=1);

namespace Autograph\Map\Annotations;

use Closure;
use Doctrine\ORM\Mapping\Annotation;

/**
 * Class ObjectField
 * @package Autograph\Map\Annotations
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class ObjectField implements Annotation
{
    public ?string $name;

    public ?string $type;

    public ?string $description = null;

    public bool $filterable = false;

    public ?string $deprecationReason = null;

    public ?Closure $resolveFn = null;
}
