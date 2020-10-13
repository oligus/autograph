<?php declare(strict_types=1);

namespace Autograph\GraphQL\Resolvers;

use Autograph\GraphQL\AppContext;
use Autograph\GraphQL\TypeManager;
use Autograph\GraphQL\Types\Filter;
use Autograph\Helpers\ClassHelper;
use Autograph\Map\MappedObjectType;
use Closure;
use Exception;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class EntityList
 * @package Autograph\GraphQL\Resolvers
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class EntityList
{
    private MappedObjectType $objectType;

    public function __construct(MappedObjectType $objectType)
    {
        $this->objectType = $objectType;
    }

    /**
     * @return array<string,array{type:\GraphQL\Type\Definition\ListOfType,resolve:\Closure,args:array{first:array{type:\GraphQL\Type\Definition\ScalarType},after:array{type:\GraphQL\Type\Definition\ScalarType,defaultValue:0},filter?:array}}>
     */
    public function getField(): array
    {
        $fieldName = $this->objectType->getQueryField();
        $type = TypeManager::get($this->objectType->getName());

        $field = [
            'type' => TypeManager::listOf($type),
            'resolve' => $this->resolver(),
            'args' => [
                'first' => [
                    'type' => TypeManager::int()
                ],
                'after' => [
                    'type' => TypeManager::int(),
                    'defaultValue' => 0
                ]
            ]
        ];

        $filter = Filter::create($this->objectType);

        if (!is_null($filter)) {
            $field['args']['filter'] = $filter;
        }

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

            $qb = $appContext->getEm()->createQueryBuilder();

            $qb->select('t')->from($className, 't');

            if (array_key_exists('filter', $args)) {
                foreach ($args['filter'] as $key => $val) {
                    $qb->andWhere($qb->expr()->eq('t.' . $key, ':' . $key));
                    $qb->setParameter($key, $val);
                }
            }

            if (array_key_exists('first', $args)) {
                $qb->setMaxResults($args['first']);
            }

            if (array_key_exists('after', $args)) {
                $qb->setFirstResult($args['after']);
            }


            $entities = $qb->getQuery()->getResult();

            $result = [];

            foreach ($entities as $entity) {
                $fields = [];
                foreach ($this->objectType->getFields() as $field) {
                    $fields[$field['name']] =  ClassHelper::getPropertyValue($entity, $field['name']);
                }
                $result[] = $fields;
            }

            return $result;
        };
    }
}
