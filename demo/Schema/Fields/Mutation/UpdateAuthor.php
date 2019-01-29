<?php declare(strict_types=1);

namespace Demo\Schema\Fields\Mutation;

use Demo\Schema\Fields\Field;
use Demo\Database\Entities\Author;
use Demo\Database\Manager;
use Demo\Schema\TypeManager;
use Demo\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use Demo\Helpers\ClassHelper;

/**
 * Class UpdateAuthor
 * @package Demo\Schema\Fields\Mutation
 */
class UpdateAuthor implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'name' => 'updateAuthor',
            'args' => [
                'id' => TypeManager::nonNull(TypeManager::id()),
                'name' => TypeManager::nonNull(TypeManager::string())
            ],
            'type' => TypeManager::get('author'),
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
        /** @var Author $author */
        $author = Manager::getInstance()
            ->getEm()
            ->getRepository('Demo\Database\Entities\Author')
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