<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Helpers\ClassHelper;
use Autograph\Tests\Application\Entities\MediaType as MediaTypeEntity;
use Autograph\Tests\Application\TypeManager;

/**
 * Class MediaType
 * @package Autograph\Tests\Application\Schema\Fields
 */
class MediaType
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('MediaType'),
            'args' => ['id' => TypeManager::id()],
            'resolve' => function ($value, array $args, AppContext $appContext): ?array {
                if (!empty($value) && array_key_exists('mediaType', $value)) {
                    $mediaType = $value['mediaType'];
                } else {
                    $mediaType = $appContext->getEm()->getRepository(MediaTypeEntity::class)->find($args['id']);
                }

                if (!$mediaType instanceof MediaTypeEntity) {
                    return null;
                }

                return [
                    'id' => ClassHelper::getPropertyValue($mediaType, 'id'),
                    'name' => ClassHelper::getPropertyValue($mediaType, 'name')
                ];
            }
        ];
    }
}
