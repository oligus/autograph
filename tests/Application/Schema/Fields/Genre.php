<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Helpers\ClassHelper;
use Autograph\Tests\Application\Entities\Genre as GenreEntity;
use Autograph\Tests\Application\TypeManager;

/**
 * Class Genre
 * @package Autograph\Tests\Schema\Fields
 */
class Genre
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Genre'),
            'args' => ['id' => TypeManager::id()],
            'resolve' => function ($value, array $args, AppContext $appContext): ?array {
                if (!empty($value) && array_key_exists('genre', $value)) {
                    $genre = $value['genre'];
                } else {
                    $genre = $appContext->getEm()->getRepository(GenreEntity::class)->find($args['id']);
                }

                if (!$genre instanceof GenreEntity) {
                    return null;
                }

                return [
                    'id' => ClassHelper::getPropertyValue($genre, 'id'),
                    'name' => ClassHelper::getPropertyValue($genre, 'name')
                ];
            }
        ];
    }
}
