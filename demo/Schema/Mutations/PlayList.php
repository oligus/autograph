<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Mutations;

use Autograph\Demo\Database\Entities\PlayLists;
use Autograph\Demo\Helpers\ClassHelper;
use Autograph\Demo\Manager;
use Autograph\Demo\Schema\Context;
use Autograph\Demo\Schema\Fields\PlayList as PlayListField;
use Autograph\Demo\Schema\TypeManager;
use Doctrine\ORM\EntityManager;
use GraphQL\Type\Definition\ResolveInfo;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use ReflectionException;
use Exception;

/**
 * Class PlayList
 * @package Autograph\Demo\Schema\Mutations
 */
class PlayList
{
    /**
     * @return array
     * @throws Exception
     */
    public function create(): array
    {
        return [
            'name' => 'createPlayList',
            'args' => [
                'playList' => TypeManager::nonNull(TypeManager::getInput('CreatePlayListInput')),
            ],
            'type' => TypeManager::get('PlayList'),

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
        $input = $args['playList'];

        $playList = new PlayLists();

        foreach ($input as $field => $value) {
            ClassHelper::setPropertyValue($playList, $field, $value);
        }

        /** @var EntityManager $em */
        $em = Manager::getInstance()->getEm();

        $em->persist($playList);
        $em->flush();

        return (new PlayListField())->resolve(['playList' => $playList], [], $context, $resolveInfo);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function update(): array
    {
        return [
            'name' => 'updatePlayList',
            'args' => [
                'playList' => TypeManager::nonNull(TypeManager::getInput('UpdatePlayListInput')),
            ],
            'type' => TypeManager::get('PlayList'),

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
        $input = $args['playList'];

        /** @var EntityManager $em */
        $em = Manager::getInstance()->getEm();

        $playList = $em->getRepository(PlayLists::class)->find($input['id']);

        foreach ($input as $field => $value) {
            ClassHelper::setPropertyValue($playList, $field, $value);
        }

        /** @var EntityManager $em */
        $em = Manager::getInstance()->getEm();

        $em->persist($playList);
        $em->flush();

        return (new PlayListField())->resolve(['playList' => $playList], [], $context, $resolveInfo);
    }


    /**
     * @return array
     * @throws Exception
     */
    public function delete(): array
    {
        return [
            'name' => 'deletePlayList',
            'args' => [
                'id' => TypeManager::nonNull(TypeManager::id()),
            ],
            'type' => TypeManager::get('PlayList'),

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

        $playList = $em->getRepository(PlayLists::class)->find($args['id']);
        $removedPlayList = clone $playList;

        $em->remove($playList);
        $em->flush();

        return (new PlayListField())->resolve(['playList' => $removedPlayList], [], $context, $resolveInfo);
    }
}
