<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use GraphQL\Type\Definition\ObjectType;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Schema\Fields\Author;
use Autograph\Demo\Schema\Fields\Comments;

/**
 * Class Post
 * @package Autograph\Demo\Schema\Types
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