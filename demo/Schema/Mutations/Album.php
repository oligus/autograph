<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Mutations;

use Autograph\Autograph;
use Autograph\Demo\Database\Entities\Albums;
use Autograph\Demo\Database\Entities\Artists;
use Autograph\Helpers\ClassHelper;
use Autograph\Context;
use Autograph\Demo\Schema\Fields\Album as AlbumField;
use Autograph\Demo\Schema\TypeManager;
use Doctrine\ORM\EntityManager;
use GraphQL\Type\Definition\ResolveInfo;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use ReflectionException;
use Exception;

/**
 * Class Album
 * @package Autograph\Demo\Schema\Mutations
 */
class Album
{
    /**
     * @return array
     * @throws Exception
     */
    public function create(): array
    {
        return [
            'name' => 'createAlbum',
            'args' => [
                'album' => TypeManager::nonNull(TypeManager::getInput('CreateAlbumInput')),
            ],
            'type' => TypeManager::get('Album'),

            'resolve' => function ($value, array $args, Context $context, ResolveInfo $resolveInfo): ?array {
                return $this->resolveCreate($value, $args, $context, $resolveInfo);
            }
        ];
    }

    /**
     * @param $value
     * @param array $args
     * @param Context $context
     * @param ResolveInfo $resolveInfo
     * @return array|null
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ReflectionException
     * @throws Exception
     */
    public function resolveCreate($value, array $args, Context $context, ResolveInfo $resolveInfo): ?array
    {
        $input = $args['album'];

        $album = new Albums();

        /** @var EntityManager $em */
        $em = Autograph::getInstance()->getEm();

        foreach ($input as $field => $value) {
            if($field === 'artist') {
                $value = $em->getRepository(Artists::class)->find($value);
            }
            ClassHelper::setPropertyValue($album, $field, $value);
        }

        $em->persist($album);
        $em->flush();

        return (new AlbumField())->resolve(['album' => $album], [], $context, $resolveInfo);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function update(): array
    {
        return [
            'name' => 'updateAlbum',
            'args' => [
                'album' => TypeManager::nonNull(TypeManager::getInput('UpdateAlbumInput')),
            ],
            'type' => TypeManager::get('Album'),

            'resolve' => function ($value, array $args, Context $context, ResolveInfo $resolveInfo): ?array {
                return $this->resolveUpdate($value, $args, $context, $resolveInfo);
            }
        ];
    }

    /**
     * @param $value
     * @param array $args
     * @param Context $context
     * @param ResolveInfo $resolveInfo
     * @return array|null
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ReflectionException
     * @throws Exception
     */
    public function resolveUpdate($value, array $args, Context $context, ResolveInfo $resolveInfo): ?array
    {
        $input = $args['album'];

        /** @var EntityManager $em */
        $em = Autograph::getInstance()->getEm();

        $album = $em->getRepository(Albums::class)->find($input['id']);

        foreach ($input as $field => $value) {
            ClassHelper::setPropertyValue($album, $field, $value);
        }

        /** @var EntityManager $em */
        $em = Autograph::getInstance()->getEm();

        $em->persist($album);
        $em->flush();

        return (new AlbumField())->resolve(['album' => $album], [], $context, $resolveInfo);
    }


    /**
     * @return array
     * @throws Exception
     */
    public function delete(): array
    {
        return [
            'name' => 'deleteAlbum',
            'args' => [
                'id' => TypeManager::nonNull(TypeManager::id()),
            ],
            'type' => TypeManager::get('Album'),

            'resolve' => function ($value, array $args, Context $context, ResolveInfo $resolveInfo): ?array {
                return $this->resolveDelete($value, $args, $context, $resolveInfo);
            }
        ];
    }

    /**
     * @param $value
     * @param array $args
     * @param Context $context
     * @param ResolveInfo $resolveInfo
     * @return array|null
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function resolveDelete($value, array $args, Context $context, ResolveInfo $resolveInfo): ?array
    {
        /** @var EntityManager $em */
        $em = Autograph::getInstance()->getEm();

        $album = $em->getRepository(Albums::class)->find($args['id']);
        $removedAlbum = clone $album;

        $em->remove($album);
        $em->flush();

        return (new AlbumField())->resolve(['album' => $removedAlbum], [], $context, $resolveInfo);
    }
}
