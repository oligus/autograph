<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Helpers\ClassHelper;
use Autograph\Tests\Application\Entities\Artist as ArtistEntity;
use Autograph\Tests\Application\TypeManager;

/**
 * Class Artist
 * @package Autograph\Tests\Application\Schema\Fields
 */
class Artist
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Artist'),
            'args' => ['id' => TypeManager::id()],
            'resolve' => function ($value, array $args, AppContext $appContext): ?array {
                if (!empty($value) && array_key_exists('artist', $value)) {
                    $artist = $value['artist'];
                } else {
                    $artist = $appContext->getEm()->getRepository(ArtistEntity::class)->find($args['id']);
                }

                if (!$artist instanceof ArtistEntity) {
                    return null;
                }

                return [
                    'id' => ClassHelper::getPropertyValue($artist, 'id'),
                    'name' => ClassHelper::getPropertyValue($artist, 'name')
                ];
            }
        ];
    }
}
