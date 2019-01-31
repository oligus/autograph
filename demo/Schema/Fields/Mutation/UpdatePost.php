<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields\Mutation;

use Autograph\Demo\Schema\Fields\Field;
use Autograph\Demo\Database\Entities\Author;
use Autograph\Demo\Database\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use Autograph\Demo\Helpers\ClassHelper;

/**
 * Class UpdateAuthor
 * @package Autograph\Demo\Schema\Fields\Mutation
 */
class UpdatePost implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'name' => 'updatePost',
            'args' => [
                'commentInput' => [
                    'type' => TypeManager::getInput('UpdatePostInputType'),
                    'name' => 'UpdatePostInputType',
                ]
            ],
            'type' => TypeManager::get('post'),
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
        die('update post');

        /** @var Author $author */
        $author = Manager::getInstance()
            ->getEm()
            ->getRepository('Autograph\Demo\Database\Entities\Author')
            ->find( (int) $args['id']);

        $author->setName($args['name']);

        Manager::getInstance()->getEm()->flush();

        return [
            'id' => ClassHelper::getPropertyValue($author, 'id'),
            'name' => ClassHelper::getPropertyValue($author, 'name'),
        ];
    }

    public static function getData(array $args)
    {
        // TODO: Implement getData() method.
    }

}