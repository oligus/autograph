<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Demo\Database\Entities\Albums;
use Autograph\Demo\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use Exception;

/**
 * Class Album
 * @package Autograph\Demo\Schema\Fields
 */
class Album
{
    /**
     * @return array<string,mixed>|null
     */
    public static function getField(): ?array
    {
        return [
            'type'    => TypeManager::get('Album'),
            'args'    => [
                'id' => [
                    'type'         => TypeManager::id(),
                    'defaultValue' => 0
                ],
            ],
            /**
             * @param mixed $value
             * @param array<string,mixed> $args
             * @return array<array>|null
             * @throws Exception
             */
            'resolve' => function ($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo): ?array {
                return self::resolve($value, $args, $appContext, $resolveInfo);
            }
        ];
    }

    /**
     * @param mixed $value
     * @param array<string,mixed> $args
     * @param AppContext $appContext
     * @param ResolveInfo $resolveInfo
     * @return array<string,mixed>|null
     * @throws Exception
     * @suppress PhanUnusedPublicMethodParameter
     */
    public static function resolve($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo): ?array
    {
        if (!empty($value) && array_key_exists('album', $value)) {
            $album = $value['album'];
        } else {
            $album = self::getData($args);
        }

        if (!$album instanceof Albums) {
            return null;
        }

        return [
            'id' => $album->getId(),
            'title' => $album->getTitle(),
            'artist' => $album->getArtists(),
        ];
    }

    /**
     * @param array<string,mixed> $args
     * @return mixed|null|object
     */
    public static function getData(array $args)
    {
        $id = array_key_exists('id', $args) ? $args['id'] : 0;

        $em = Manager::getInstance()->getEm();

        $repository = $em->getRepository(Albums::class);
        return $repository->find($id);
    }
}
