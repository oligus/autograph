<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Tests\Application\Entities\Genre as GenreEntity;
use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Genre
 * @package Autograph\Tests\Schema\Fields
 */
class Genres
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Genres'),
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
                $qb->select('t')->from(GenreEntity::class, 't');

                if (array_key_exists('first', $args)) {
                    $qb->setMaxResults($args['first']);
                }

                if (array_key_exists('after', $args)) {
                    $qb->setFirstResult($args['after']);
                }

                $entities = $qb->getQuery()->getResult();


                $nodes = [];

                /** @var GenreEntity $genre */
                foreach ($entities as $genre) {
                    $resolveFn = (new Genre())->getField()['resolve'];
                    $nodes[] = $resolveFn(
                        ['genre' => $genre],
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
