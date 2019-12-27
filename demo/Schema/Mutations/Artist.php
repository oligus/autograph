<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Mutations;

use Autograph\Autograph;
use Autograph\Demo\Database\Entities\Artists;
use Autograph\Helpers\ClassHelper;
use Autograph\Context;
use Autograph\Demo\Schema\Fields\Artist as ArtistField;
use Autograph\Demo\Schema\TypeManager;
use Doctrine\ORM\EntityManager;
use GraphQL\Type\Definition\ResolveInfo;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use ReflectionException;
use Exception;

/**
 * Class Artist
 * @package Autograph\Demo\Schema\Mutations
 */
class Artist
{
    /**
     * @return array
     * @throws Exception
     */
    public function create(): array
    {
        return [
            'name' => 'createArtist',
            'args' => [
                'artist' => TypeManager::nonNull(TypeManager::getInput('CreateArtistInput')),
            ],
            'type' => TypeManager::get('Artist'),

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
        $input = $args['artist'];

        $artist = new Artists();

        foreach ($input as $field => $value) {
            ClassHelper::setPropertyValue($artist, $field, $value);
        }

        /** @var EntityManager $em */
        $em = Autograph::getInstance()->getEm();

        $em->persist($artist);
        $em->flush();

        return (new ArtistField())->resolve(['artist' => $artist], [], $context, $resolveInfo);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function update(): array
    {
        return [
            'name' => 'updateArtist',
            'args' => [
                'artist' => TypeManager::nonNull(TypeManager::getInput('UpdateArtistInput')),
            ],
            'type' => TypeManager::get('Artist'),

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
        $input = $args['artist'];

        /** @var EntityManager $em */
        $em = Autograph::getInstance()->getEm();

        $artist = $em->getRepository(Artists::class)->find($input['id']);

        foreach ($input as $field => $value) {
            ClassHelper::setPropertyValue($artist, $field, $value);
        }

        /** @var EntityManager $em */
        $em = Autograph::getInstance()->getEm();

        $em->persist($artist);
        $em->flush();

        return (new ArtistField())->resolve(['artist' => $artist], [], $context, $resolveInfo);
    }


    /**
     * @return array
     * @throws Exception
     */
    public function delete(): array
    {
        return [
            'name' => 'deleteArtist',
            'args' => [
                'id' => TypeManager::nonNull(TypeManager::id()),
            ],
            'type' => TypeManager::get('Artist'),

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

        $artist = $em->getRepository(Artists::class)->find($args['id']);
        $removedArtist = clone $artist;

        $em->remove($artist);
        $em->flush();

        return (new ArtistField())->resolve(['artist' => $removedArtist], [], $context, $resolveInfo);
    }
}
