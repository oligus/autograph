<?php declare(strict_types=1);

namespace Autograph\GraphQL\Resolvers;

use Autograph\GraphQL\AppContext;
use Autograph\GraphQL\TypeManager;
use Autograph\GraphQL\Types\Filter;
use Autograph\GraphQL\Types\ListType;
use Autograph\Helpers\ClassHelper;
use Autograph\Map\MappedObjectType;
use Closure;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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
     * @return array<string,array{type:\GraphQL\Type\Definition\ObjectType,resolve:\Closure,args:array{first:array{type:\GraphQL\Type\Definition\ScalarType},after:array{type:\GraphQL\Type\Definition\ScalarType,defaultValue:0},filter?:\GraphQL\Type\Definition\InputObjectType[]}}>
     */
    public function getField(): array
    {
        $type = TypeManager::get($this->objectType->getName());
        $fieldName = $this->objectType->getQueryField();

        $returnType = ListType::create($fieldName, $type);

        $field = [
            'type' => $returnType,
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
            $em = $appContext->getEm();

            $qb = $em->createQueryBuilder();

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

            $nodes = [];

            foreach ($entities as $entity) {
                $fields = [];
                foreach ($this->objectType->getFields() as $field) {
                    $fields[$field['name']] =  ClassHelper::getPropertyValue($entity, $field['name']);
                }
                $nodes[] = $fields;
            }

            return [
                /**
                 * @throws NoResultException
                 * @throws NonUniqueResultException
                 */
                'totalCount' => function () use ($className, $em): int {
                    $qb = $em->createQueryBuilder();
                    $qb->select('COUNT(t)')->from($className, 't');
                    return (int) $qb->getQuery()->getSingleScalarResult();
                },
                /** @return array<mixed> */
                'nodes' => function () use ($nodes): array {
                    return $nodes;
                }
            ];
        };
    }
}
