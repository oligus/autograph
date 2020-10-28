<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Helpers\ClassHelper;
use Autograph\Tests\Application\Entities\Album as AlbumEntity;
use Autograph\Tests\Application\TypeManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Albums
 * @package Autograph\Tests\Application\Schema\Fields
 */
class Albums
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Albums'),
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
                $qb->select('t')->from(AlbumEntity::class, 't');

                if (array_key_exists('first', $args)) {
                    $qb->setMaxResults($args['first']);
                }

                if (array_key_exists('after', $args)) {
                    $qb->setFirstResult($args['after']);
                }

                $query = $qb->getQuery();
                $query->setFetchMode(AlbumEntity::class, 'artist', ClassMetadata::FETCH_EAGER);
                $entities = $query->getResult();

                $nodes = [];

                /** @var AlbumEntity $album */
                foreach ($entities as $album) {
                    $resolveFn = (new Album())->getField()['resolve'];
                    $nodes[] = $resolveFn(
                        ['album' => $album],
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
