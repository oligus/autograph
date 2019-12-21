<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Demo\Database\Entities\MediaTypes;
use Autograph\Demo\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Schema\Context;
use GraphQL\Type\Definition\ResolveInfo;
use Exception;

/**
 * Class Genre
 * @package Autograph\Demo\Schema\Fields
 */
class MediaType
{
    /**
     * @return array<string,mixed>|null
     */
    public static function getField(): ?array
    {
        return [
            'type'    => TypeManager::get('MediaType'),
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
        if (!empty($value) && array_key_exists('mediaType', $value)) {
            $genre = $value['mediaType'];
        } else {
            $genre = self::getData($args);
        }

        if (!$genre instanceof MediaTypes) {
            return null;
        }

        return [
            'id' => $genre->getId(),
            'name' => $genre->getName()
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

        $repository = $em->getRepository(Genres::class);
        return $repository->find($id);
    }
}
