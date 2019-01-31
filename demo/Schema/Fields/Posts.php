<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Demo\Database\Entities\Post;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Schema\AppContext;
use Autograph\Demo\Database\Manager;
use Autograph\Demo\Helpers\ClassHelper;
use Autograph\Demo\Schema\Query\Filter;
use Autograph\Demo\Schema\Query\FilterDoctrineCollection;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Posts
 * @package Autograph\Demo\Schema\Fields
 */
class Posts implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        $filter = Filter::create('PostFilter');
        $filter->addField('id', ['type' => TypeManager::id()]);
        $filter->addField('title', ['type' => TypeManager::string()]);
        $filter->addField('content', ['type' => TypeManager::string()]);

        Manager::getInstance()->getFilterCollection()->add($filter);

        return [
            'type' => TypeManager::get('posts'),
            'args' => [
                'filter' => Manager::getInstance()->getFilterCollection()->get('PostFilter'),
                'first' => ['type' => TypeManager::int()],
                'offset' => ['type' => TypeManager::int(), 'defaultValue' => 0],
                'after' => ['type' => TypeManager::int(), 'defaultValue' => 0],
            ],
            'resolve' => function ($value, $args, AppContext $appContext, ResolveInfo $resolveInfo) {
                return self::resolve($value, $args, $appContext, $resolveInfo);
            }
        ];
    }

    /**
     * @param $value
     * @param array $args
     * @param AppContext $appContext
     * @param ResolveInfo $resolveInfo
     * @return array|mixed|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \ReflectionException
     */
    public static function resolve($value, $args, AppContext $appContext, ResolveInfo $resolveInfo)
    {
        if (!empty($value) && array_key_exists('posts', $value)) {
            $filter = new FilterDoctrineCollection($value['posts'], $args);
            $posts = $filter->getResult();
        } elseif ($value instanceof Post) {
            $posts = [$value];
        } else {
            $posts = self::getData($args);
        }

        $nodes = [];

        /** @var Post $post */
        foreach ($posts as $post) {
            $nodes[] = [
                'id' => ClassHelper::getPropertyValue($post, 'id'),
                'title' => ClassHelper::getPropertyValue($post, 'title'),
                'content' => ClassHelper::getPropertyValue($post, 'content'),
                'date' => ClassHelper::getPropertyValue($post, 'date')->format('Y-m-d'),
                'comments' => ClassHelper::getPropertyValue($post, 'comments'),
                'author' => ClassHelper::getPropertyValue($post, 'author')
            ];
        }

        return [
            'total' => self::getCount(),
            'count' => count($posts),
            'nodes' => $nodes
        ];
    }

    /**
     * @param array $args
     * @return mixed
     */
    public static function getData(array $args)
    {
        /** @var \Autograph\Demo\Database\Repositories\CommonRepository $repo */
        $repo = Manager::getInstance()->getEm()->getRepository(Post::class);
        return $repo->filter($args);
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public static function getCount()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = Manager::getInstance()->getEm();

        /** @var \Autograph\Demo\Database\Repositories\CommonRepository $repo */
        $repo = $em->getRepository(Post::class);

        return $repo->getCount();
    }
}
