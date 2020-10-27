<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Tests\Application\Entities\MediaType as MediaTypeEntity;
use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class MediaTypes
 * @package Autograph\Tests\Application\Schema\Fields
 */
class MediaTypes
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('MediaTypes'),
            'args' => [
                'first' => [
                    'type' => TypeManager::int()
                ],
                'after' => [
                    'type' => TypeManager::int(),
                    'defaultValue' => 0
                ]
            ],
            'resolve' => function ($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo): array {
                $em = $appContext->getEm();
                $qb = $em->createQueryBuilder();
                $qb->select('t')->from(MediaTypeEntity::class, 't');

                if (array_key_exists('first', $args)) {
                    $qb->setMaxResults($args['first']);
                }

                if (array_key_exists('after', $args)) {
                    $qb->setFirstResult($args['after']);
                }

                $entities = $qb->getQuery()->getResult();

                $nodes = [];

                /** @var MediaTypeEntity $mediaType */
                foreach ($entities as $mediaType) {
                    $resolveFn = (new MediaType())->getField()['resolve'];
                    $nodes[] = $resolveFn(
                        ['mediaType' => $mediaType],
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
