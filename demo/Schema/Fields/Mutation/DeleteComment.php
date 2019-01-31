<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields\Mutation;

use Autograph\Demo\Schema\Fields\Field;
use Autograph\Demo\Database\Entities\Comment;
use Autograph\Demo\Database\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use Autograph\Demo\Helpers\ClassHelper;

/**
 * Class DeleteComment
 * @package Autograph\Demo\Schema\Fields\Mutation
 */
class DeleteComment
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'name' => 'deleteComment',
            'args' => [
                'id' => TypeManager::nonNull(TypeManager::id())
            ],
            'type' => TypeManager::get('comment'),
            'resolve' => function ($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo) {
                return self::resolve($value, $args, $appContext, $resolveInfo);
            }
        ];
    }

    /**
     * @param $value
     * @param array $args
     * @param AppContext $appContext
     * @param ResolveInfo $resolveInfo
     * @return mixed
     * @throws \Exception
     */
    public static function resolve($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo)
    {
        $id = (int) $args['id'];

        $comment = Manager::getInstance()
            ->getEm()
            ->getRepository('Autograph\Demo\Database\Entities\Comment')
            ->find($id);

        if(!$comment instanceof Comment) {
            throw new \Exception('Post with id: ' . $id . ' not found.');
        }

        $result = [
            'id' => ClassHelper::getPropertyValue($comment, 'id'),
            'author' => ClassHelper::getPropertyValue($comment, 'author'),
            'title' => ClassHelper::getPropertyValue($comment, 'title'),
            'content' => ClassHelper::getPropertyValue($comment, 'content'),
            'date' => ClassHelper::getPropertyValue($comment, 'date')->format('Y-m-d')
        ];

        Manager::getInstance()->getEm()->remove($comment);
        Manager::getInstance()->getEm()->flush();

        return $result;
    }
}