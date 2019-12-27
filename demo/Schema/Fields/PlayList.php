<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Demo\Database\Entities\Playlists;
use Autograph\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Schema\Context;
use GraphQL\Type\Definition\ResolveInfo;
use Exception;

/**
 * Class PlayList
 * @package Autograph\Demo\Schema\Fields
 */
class PlayList
{
    /**
     * @return array<string,mixed>|null
     */
    public static function getField(): ?array
    {
        return [
            'type'    => TypeManager::get('PlayList'),
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
            'resolve' => function ($value, array $args, Context $appContext, ResolveInfo $resolveInfo): ?array {
                return self::resolve($value, $args, $appContext, $resolveInfo);
            }
        ];
    }

    /**
     * @param mixed $value
     * @param array<string,mixed> $args
     * @param Context $appContext
     * @param ResolveInfo $resolveInfo
     * @return array<string,mixed>|null
     * @throws Exception
     * @suppress PhanUnusedPublicMethodParameter
     */
    public static function resolve($value, array $args, Context $appContext, ResolveInfo $resolveInfo): ?array
    {
        if (!empty($value) && array_key_exists('playList', $value)) {
            $playList = $value['playList'];
        } else {
            $playList = self::getData($args);
        }

        if (!$playList instanceof Playlists) {
            return null;
        }

        return [
            'id' => $playList->getId(),
            'name' => $playList->getName()
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

        $repository = $em->getRepository(Playlists::class);
        return $repository->find($id);
    }
}
