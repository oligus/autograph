<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Tests\Application\Entities\Employee as EmployeeEntity;
use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Employees
 * @package Autograph\Tests\Application\Schema\Fields
 */
class Employees
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Employees'),
            'args' => [
                'first' => [
                    'type' => TypeManager::int()
                ],
                'after' => [
                    'type' => TypeManager::int(),
                    'defaultValue' => 0
                ]
            ],
            'resolve' => function ($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo) {
                $em = $appContext->getEm();
                $qb = $em->createQueryBuilder();
                $qb->select('t')->from(EmployeeEntity::class, 't');

                if (array_key_exists('first', $args)) {
                    $qb->setMaxResults($args['first']);
                }

                if (array_key_exists('after', $args)) {
                    $qb->setFirstResult($args['after']);
                }

                $entities = $qb->getQuery()->getResult();

                $nodes = [];

                /** @var EmployeeEntity $employee */
                foreach ($entities as $employee) {
                    $resolveFn = (new Employee())->getField()['resolve'];
                    $nodes[] = $resolveFn(
                        ['employee' => $employee],
                        [],
                        $appContext,
                        $resolveInfo
                    );
                }

                return [
                    'nodes' => $nodes
                ];
            }
        ];
    }
}
