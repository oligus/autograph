<?php declare(strict_types=1);

namespace Demo\Schema\Fields\Mutation;

use Demo\Database\Entities\Post;
use Demo\Schema\Fields\Field;
use Demo\Database\Entities\Author;
use Demo\Database\Manager;
use Demo\Schema\TypeManager;
use Demo\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use Demo\Helpers\ClassHelper;

/**
 * Class CreateAuthor
 * @package Demo\Schema\Fields\Mutation
 */
class CreatePost implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'name' => 'createPost',
            'args' => [
                'postInputType' => [
                    'type' => TypeManager::getInput('PostInputType'),
                    'name' => 'input',
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
        $values = $args['input'];

        $post = new Post();
        $post->setTitle($values['title']);
        $post->setContent($values['content']);

        $author = Manager::getInstance()->getEm()->getReference(Author::class, $values['authorId']);

        if(!$author instanceof Author) {
            throw new \Exception('Author with id ' . $values['authorId'] . ' not found.');
        }

        $post->setAuthor($author);
        $post->setDate(new \DateTime());

        Manager::getInstance()->getEm()->persist($post);
        Manager::getInstance()->getEm()->flush();

        return [
            'id' => ClassHelper::getPropertyValue($post, 'id'),
            'title' => ClassHelper::getPropertyValue($post, 'title'),
            'content' => ClassHelper::getPropertyValue($post, 'content'),
            'date' => ClassHelper::getPropertyValue($post, 'date')->format('Y-m-d'),
            'author' => ClassHelper::getPropertyValue($post, 'author')
        ];
    }

    public static function getData(array $args)
    {
        // TODO: Implement getData() method.
    }

}