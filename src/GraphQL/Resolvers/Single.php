<?php declare(strict_types=1);

namespace Autograph\GraphQL\Resolvers;

use Autograph\GraphQL\AppContext;
use Autograph\GraphQL\TypeManager;
use Autograph\Helpers\ClassHelper;
use Autograph\Map\MappedObjectType;
use Autograph\Tests\Application\Entities\Album;
use Closure;
use Exception;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class EntityList
 * @package Autograph\GraphQL\Resolvers
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class Single
{
    private MappedObjectType $objectType;

    public function __construct(MappedObjectType $objectType)
    {
        $this->objectType = $objectType;
    }

    /**
     * @return array<mixed>
     */
    public function getField(): array
    {
        $type = TypeManager::get($this->objectType->getName());
        $fieldName = $this->objectType->getQueryFieldName();

        $field = [
            'type' => $type,
            'resolve' => $this->resolver(),
            'args' => [
                [
                    'name' => 'id',
                    'type' => TypeManager::nonNull(TypeManager::id())
                ]
            ]
        ];

        $result = [];
        $result[$fieldName] = $field;

        return $result;
    }

    public function resolver(): Closure
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
            $em = $appContext->getEm();

            $entity = $em->getRepository($className)->find($args['id']);

            if (is_null($entity)) {
                throw new Exception('Entity not found, id: ' . $args['id']);
            }

            $fields = [];

            foreach ($this->objectType->getFields() as $field) {
                $fields[$field['name']] = ClassHelper::getPropertyValue($entity, $field['name']);
            }

            return $fields;
        };
    }
}
