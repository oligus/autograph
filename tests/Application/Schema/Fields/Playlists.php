<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Tests\Application\Entities\Playlist as PlaylistEntity;
use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Playlists
 * @package Autograph\Tests\Application\Schema\Fields
 */
class Playlists
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Playlists'),
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
                $qb->select('t')->from(PlaylistEntity::class, 't');

                if (array_key_exists('first', $args)) {
                    $qb->setMaxResults($args['first']);
                }

                if (array_key_exists('after', $args)) {
                    $qb->setFirstResult($args['after']);
                }

                $query = $qb->getQuery();
                $entities = $query->getResult();

                $nodes = [];

                /** @var PlaylistEntity $playlist */
                foreach ($entities as $playlist) {
                    $resolveFn = (new Playlist())->getField()['resolve'];
                    $nodes[] = $resolveFn(
                        ['playlist' => $playlist],
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
