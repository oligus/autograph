<?php declare(strict_types=1);

namespace Demo\Schema\Types;

use GraphQL\Type\Definition\ObjectType;
use Demo\Schema\Fields\Mutation\CreateAuthor;
use Demo\Schema\Fields\Mutation\CreateComment;
use Demo\Schema\Fields\Mutation\CreatePost;
use Demo\Schema\Fields\Mutation\DeleteAuthor;
use Demo\Schema\Fields\Mutation\DeleteComment;
use Demo\Schema\Fields\Mutation\DeletePost;
use Demo\Schema\Fields\Mutation\UpdateAuthor;
use Demo\Schema\Fields\Mutation\UpdateComment;
use Demo\Schema\Fields\Mutation\UpdatePost;

/**
 * Class QueryType
 * @package CM\Schema\Type
 */
class MutationType extends ObjectType
{
    /**
     * MutationType constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Mutation',
            'description' => 'Mutate blog data',
            'fields' => function() {
                return [
                    'createAuthor'  => CreateAuthor::getField(),
                    'updateAuthor'  => UpdateAuthor::getField(),
                    'deleteAuthor'  => DeleteAuthor::getField(),

                    'createPost'    => CreatePost::getField(),
                    'updatePost'    => UpdatePost::getField(),
                    'deletePost'    => DeletePost::getField(),

                    'createComment' => CreateComment::getField(),
                    'updateComment' => UpdateComment::getField(),
                    'deleteComment'  => DeleteComment::getField(),
                ];
            }
        ];

        parent::__construct($config);
    }
}