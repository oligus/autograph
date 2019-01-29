<?php declare(strict_types=1);

namespace Demo\Schema\Types;

use GraphQL\Type\Definition\ObjectType;
use Demo\Schema\TypeManager;
use Demo\Schema\Fields\Author;
use Demo\Schema\Fields\Comments;

/**
 * Class Post
 * @package Demo\Schema\Types
 */
class Post extends ObjectType
{
    /**
     * Artist constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Post',
            'description' => 'A blog post',
            'fields' => function() {
                return [
                    'id' => ['type' => TypeManager::ID()],
                    'title' => ['type' => TypeManager::string()],
                    'content' => ['type' => TypeManager::string()],
                    'date' => ['type' => TypeManager::string()],
                    'author' => Author::getField(),
                    'comments' => Comments::getField()
                ];
            }
        ];

        parent::__construct($config);
    }
}

/*
 *     id: ID!
    author: Author!
    title: String
    content: String
    date: DateTime!
    comments: [Comment!]!
 */