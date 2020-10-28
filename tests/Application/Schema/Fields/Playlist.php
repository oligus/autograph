<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Helpers\ClassHelper;
use Autograph\Tests\Application\Entities\Playlist as PlaylistEntity;
use Autograph\Tests\Application\TypeManager;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class Playlist
 * @package Autograph\Tests\Application\Schema\Fields
 */
class Playlist
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Playlist'),
            'args' => ['id' => TypeManager::id()],
            'resolve' => function ($value, array $args, AppContext $appContext): ?array {
                if (!empty($value) && array_key_exists('playlist', $value)) {
                    $playlist = $value['playlist'];
                } else {
                    $em = $appContext->getEm();
                    $qb = $em->createQueryBuilder();
                    $qb->select('t')->from(PlaylistEntity::class, 't');
                    $qb->where($qb->expr()->eq('t.id', ':id'));
                    $qb->setParameter(':id', $args['id']);

                    $query = $qb->getQuery();

                    $playlist = $query->getOneOrNullResult();
                }

                if (!$playlist instanceof PlaylistEntity) {
                    return null;
                }

                return [
                    'id' => ClassHelper::getPropertyValue($playlist, 'id'),
                    'name' => ClassHelper::getPropertyValue($playlist, 'name')
                ];
            }
        ];
    }
}
