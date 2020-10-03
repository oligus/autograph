<?php declare(strict_types=1);

namespace Autograph\GraphQL;

use Autograph\Helpers\ClassHelper;
use Autograph\Map\MappedObjectType;
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

    public function resolve()
    {
        return function ($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo) {
            $entity = $appContext->getEm()->getRepository($this->objectType->getClassName())->find($args['id']);

            $result = [];

            foreach ($this->objectType->getFields() as $field) {
                $result[$field['name']] =  ClassHelper::getPropertyValue($entity, $field['name']);
            }

            return $result;
        };
    }
}
