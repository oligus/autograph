<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Helpers\ClassHelper;
use Autograph\Tests\Application\Entities\Album as AlbumEntity;
use Autograph\Tests\Application\TypeManager;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class Album
 * @package Autograph\Tests\Application\Schema\Fields
 */
class Album
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Album'),
            'args' => ['id' => TypeManager::id()],
            'resolve' => function ($value, array $args, AppContext $appContext): ?array {
                if (!empty($value) && array_key_exists('album', $value)) {
                    $album = $value['album'];
                } else {
                    $em = $appContext->getEm();
                    $qb = $em->createQueryBuilder();
                    $qb->select('t')->from(AlbumEntity::class, 't');
                    $qb->where($qb->expr()->eq('t.id', ':id'));
                    $qb->setParameter(':id', $args['id']);

                    $query = $qb->getQuery();
                    $query->setFetchMode(AlbumEntity::class, 'artist', ClassMetadata::FETCH_EAGER);

                    $album = $query->getOneOrNullResult();
                }

                if (!$album instanceof AlbumEntity) {
                    return null;
                }

                return [
                    'id' => ClassHelper::getPropertyValue($album, 'id'),
                    'title' => ClassHelper::getPropertyValue($album, 'title'),
                    'artist' => ClassHelper::getPropertyValue($album, 'artist')
                ];
            }
        ];
    }
}
