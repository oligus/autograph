<?php declare(strict_types=1);

namespace Autograph\GraphQL;

use Autograph\Helpers\ClassHelper;
use Autograph\Map\MappedObjectType;
use Closure;
use Exception;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class EntityResolver
 * @package Autograph\GraphQL
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class EntityResolver
{
    private MappedObjectType $objectType;

    public function __construct(MappedObjectType $objectType)
    {
        $this->objectType = $objectType;
    }

    public function resolve(): Closure
    {
        /**
         * @param mixed $value
         * @param array<mixed> $args
         * @return array<mixed>
         * @suppress PhanUnusedClosureParameter
         * @throws Exception
         */
        return function ($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo): array {
            $className = $this->objectType->getClassName();
            $entity = $appContext->getEm()->getRepository($className)->find($args['id']);

            $result = [];

            if ($entity instanceof $className) {
                foreach ($this->objectType->getFields() as $field) {
                    $result[$field['name']] =  ClassHelper::getPropertyValue($entity, $field['name']);
                }
            }

            return $result;
        };
    }
}
