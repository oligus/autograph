<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Demo\Database\Entities\Artists;
use Autograph\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Context;
use GraphQL\Type\Definition\ResolveInfo;
use Exception;

/**
 * Class Artist
 * @package Autograph\Demo\Schema\Fields
 */
class Artist
{
    /**
     * @return array<string,mixed>|null
     */
    public function getField(): ?array
    {
        return [
            'type'    => TypeManager::get('Artist'),
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
            'resolve' => function ($value, array $args, Context $context, ResolveInfo $resolveInfo): ?array {
                return self::resolve($value, $args, $context, $resolveInfo);
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
    public function resolve($value, array $args, Context $context, ResolveInfo $resolveInfo): ?array
    {
        if (!empty($value) && array_key_exists('artist', $value)) {
            $artist = $value['artist'];
        } else {
            $artist = self::getData($args);
        }

        if (!$artist instanceof Artists) {
            return null;
        }

        return [
            'id' => $artist->getId(),
            'name' => $artist->getName(),
            'albums' => $artist->getAlbums()
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

        $repository = $em->getRepository(Artists::class);
        return $repository->find($id);
    }
}
