<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Helpers\ClassHelper;
use Autograph\Tests\Application\Entities\Track as TrackEntity;
use Autograph\Tests\Application\TypeManager;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class Track
 * @package Autograph\Tests\Application\Schema\Fields
 */
class Track
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Track'),
            'args' => ['id' => TypeManager::id()],
            'resolve' => function ($value, array $args, AppContext $appContext): ?array {
                if (!empty($value) && array_key_exists('track', $value)) {
                    $track = $value['track'];
                } else {
                    $em = $appContext->getEm();
                    $qb = $em->createQueryBuilder();
                    $qb->select('t')->from(TrackEntity::class, 't');
                    $qb->where($qb->expr()->eq('t.id', ':id'));
                    $qb->setParameter(':id', $args['id']);

                    $query = $qb->getQuery();
                    $query->setFetchMode(TrackEntity::class, 'album', ClassMetadata::FETCH_EAGER);
                    $query->setFetchMode(TrackEntity::class, 'mediaType', ClassMetadata::FETCH_EAGER);
                    $query->setFetchMode(TrackEntity::class, 'genre', ClassMetadata::FETCH_EAGER);
                    $query->setFetchMode(TrackEntity::class, 'playlists', ClassMetadata::FETCH_EAGER);

                    $track = $query->getOneOrNullResult();
                }

                if (!$track instanceof TrackEntity) {
                    return null;
                }

                return [
                    'id' => ClassHelper::getPropertyValue($track, 'id'),
                    'name' => ClassHelper::getPropertyValue($track, 'name'),
                    'composer' => ClassHelper::getPropertyValue($track, 'composer'),
                    'milliseconds' => ClassHelper::getPropertyValue($track, 'milliseconds'),
                    'bytes' => ClassHelper::getPropertyValue($track, 'bytes'),
                    'unitPrice' => ClassHelper::getPropertyValue($track, 'unitPrice'),
                    'album' => ClassHelper::getPropertyValue($track, 'album'),
                    'mediaType' => ClassHelper::getPropertyValue($track, 'mediaType'),
                    'genre' => ClassHelper::getPropertyValue($track, 'genre'),
                    'playlists' => ClassHelper::getPropertyValue($track, 'playlists'),
                ];
            }
        ];
    }
}
