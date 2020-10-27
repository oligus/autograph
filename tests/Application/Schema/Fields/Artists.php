<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Tests\Application\Entities\Artist as ArtistEntity;
use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Artists
 * @package Autograph\Tests\Application\Schema\Fields
 */
class Artists
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Artists'),
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
                $qb->select('t')->from(ArtistEntity::class, 't');

                if (array_key_exists('first', $args)) {
                    $qb->setMaxResults($args['first']);
                }

                if (array_key_exists('after', $args)) {
                    $qb->setFirstResult($args['after']);
                }

                $entities = $qb->getQuery()->getResult();

                $nodes = [];

                /** @var ArtistEntity $artist */
                foreach ($entities as $artist) {
                    $resolveFn = (new Artist())->getField()['resolve'];
                    $nodes[] = $resolveFn(
                        ['artist' => $artist],
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
