<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Mutations;

use Autograph\Demo\Database\Entities\MediaTypes;
use Autograph\Demo\Helpers\ClassHelper;
use Autograph\Manager;
use Autograph\Demo\Schema\Context;
use Autograph\Demo\Schema\Fields\MediaType as MediaTypeField;
use Autograph\Demo\Schema\TypeManager;
use Doctrine\ORM\EntityManager;
use GraphQL\Type\Definition\ResolveInfo;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use ReflectionException;
use Exception;

/**
 * Class MediaType
 * @package Autograph\Demo\Schema\Mutations
 */
class MediaType
{
    /**
     * @return array
     * @throws Exception
     */
    public function create(): array
    {
        return [
            'name' => 'createMediaType',
            'args' => [
                'mediaType' => TypeManager::nonNull(TypeManager::getInput('CreateMediaTypeInput')),
            ],
            'type' => TypeManager::get('MediaType'),

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
        $input = $args['mediaType'];

        $mediaType = new MediaTypes();

        foreach ($input as $field => $value) {
            ClassHelper::setPropertyValue($mediaType, $field, $value);
        }

        /** @var EntityManager $em */
        $em = Manager::getInstance()->getEm();

        $em->persist($mediaType);
        $em->flush();

        return (new MediaTypeField())->resolve(['mediaType' => $mediaType], [], $context, $resolveInfo);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function update(): array
    {
        return [
            'name' => 'updateMediaType',
            'args' => [
                'mediaType' => TypeManager::nonNull(TypeManager::getInput('UpdateMediaTypeInput')),
            ],
            'type' => TypeManager::get('MediaType'),

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
        $input = $args['mediaType'];

        /** @var EntityManager $em */
        $em = Manager::getInstance()->getEm();

        $mediaType = $em->getRepository(MediaTypes::class)->find($input['id']);

        foreach ($input as $field => $value) {
            ClassHelper::setPropertyValue($mediaType, $field, $value);
        }

        /** @var EntityManager $em */
        $em = Manager::getInstance()->getEm();

        $em->persist($mediaType);
        $em->flush();

        return (new MediaTypeField())->resolve(['mediaType' => $mediaType], [], $context, $resolveInfo);
    }


    /**
     * @return array
     * @throws Exception
     */
    public function delete(): array
    {
        return [
            'name' => 'deleteMediaType',
            'args' => [
                'id' => TypeManager::nonNull(TypeManager::id()),
            ],
            'type' => TypeManager::get('MediaType'),

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

        $mediaType = $em->getRepository(MediaTypes::class)->find($args['id']);
        $removedMediaType = clone $mediaType;

        $em->remove($mediaType);
        $em->flush();

        return (new MediaTypeField())->resolve(['mediaType' => $removedMediaType], [], $context, $resolveInfo);
    }
}
