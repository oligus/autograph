<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Mutations;

use Autograph\Demo\Database\Entities\Genres;
use Autograph\Demo\Helpers\ClassHelper;
use Autograph\Demo\Manager;
use Autograph\Demo\Schema\Context;
use Autograph\Demo\Schema\Fields\Genre as GenreField;
use Autograph\Demo\Schema\TypeManager;
use Doctrine\ORM\EntityManager;
use GraphQL\Type\Definition\ResolveInfo;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use ReflectionException;
use Exception;

/**
 * Class Genre
 * @package Autograph\Demo\Schema\Mutations
 */
class Genre
{
    /**
     * @return array
     * @throws Exception
     */
    public function create(): array
    {
        return [
            'name' => 'createGenre',
            'args' => [
                'genre' => TypeManager::nonNull(TypeManager::getInput('CreateGenreInput')),
            ],
            'type' => TypeManager::get('Genre'),

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
        $input = $args['genre'];

        $genre = new Genres();

        foreach ($input as $field => $value) {
            ClassHelper::setPropertyValue($genre, $field, $value);
        }

        /** @var EntityManager $em */
        $em = Manager::getInstance()->getEm();

        $em->persist($genre);
        $em->flush();

        return (new GenreField())->resolve(['genre' => $genre], [], $context, $resolveInfo);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function update(): array
    {
        return [
            'name' => 'updateGenre',
            'args' => [
                'genre' => TypeManager::nonNull(TypeManager::getInput('UpdateGenreInput')),
            ],
            'type' => TypeManager::get('Genre'),

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
        $input = $args['genre'];

        /** @var EntityManager $em */
        $em = Manager::getInstance()->getEm();

        $genre = $em->getRepository(Genres::class)->find($input['id']);

        foreach ($input as $field => $value) {
            ClassHelper::setPropertyValue($genre, $field, $value);
        }

        /** @var EntityManager $em */
        $em = Manager::getInstance()->getEm();

        $em->persist($genre);
        $em->flush();

        return (new GenreField())->resolve(['genre' => $genre], [], $context, $resolveInfo);
    }


    /**
     * @return array
     * @throws Exception
     */
    public function delete(): array
    {
        return [
            'name' => 'deleteGenre',
            'args' => [
                'id' => TypeManager::nonNull(TypeManager::id()),
            ],
            'type' => TypeManager::get('Genre'),

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
        $em = Manager::getInstance()->getEm();

        $genre = $em->getRepository(Genres::class)->find($args['id']);
        $removedGenre = clone $genre;

        $em->remove($genre);
        $em->flush();

        return (new GenreField())->resolve(['genre' => $removedGenre], [], $context, $resolveInfo);
    }
}
