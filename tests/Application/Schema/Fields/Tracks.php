<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Tests\Application\Entities\Track as TrackEntity;
use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Tracks
 * @package Autograph\Tests\Application\Schema\Fields
 */
class Tracks
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Tracks'),
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
                if (!empty($value) && array_key_exists('tracks', $value)) {
                    $entities = $value['tracks'];
                } else {
                    $em = $appContext->getEm();
                    $qb = $em->createQueryBuilder();
                    $qb->select('t')->from(TrackEntity::class, 't');

                    if (array_key_exists('first', $args)) {
                        $qb->setMaxResults($args['first']);
                    }

                    if (array_key_exists('after', $args)) {
                        $qb->setFirstResult($args['after']);
                    }

                    $query = $qb->getQuery();
                    $entities = $query->getResult();
                }

                $nodes = [];

                /** @var TrackEntity $track */
                foreach ($entities as $track) {
                    $resolveFn = (new Track())->getField()['resolve'];
                    $nodes[] = $resolveFn(
                        ['track' => $track],
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
