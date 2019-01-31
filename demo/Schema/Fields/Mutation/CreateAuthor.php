<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields\Mutation;

use Autograph\Demo\Database\Entities\Author;
use Autograph\Demo\Database\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use Autograph\Demo\Helpers\ClassHelper;

/**
 * Class CreateAuthor
 * @package Autograph\Demo\Schema\Fields\Mutation
 */
class CreateAuthor
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'name' => 'createAuthor',
            'args' => [
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
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \ReflectionException
     */
    public static function resolve($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo)
    {
        $author = Author::create($args['name']);

        Manager::getInstance()->getEm()->persist($author);
        Manager::getInstance()->getEm()->flush();

        return [
            'id' => ClassHelper::getPropertyValue($author, 'id'),
            'name' => ClassHelper::getPropertyValue($author, 'name'),
        ];
    }
}