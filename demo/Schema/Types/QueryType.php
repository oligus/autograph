<?php declare(strict_types=1);

namespace Demo\Schema\Types;

use Demo\Schema\Fields;
use GraphQL\Type\Definition\ObjectType;

/**ç
 * Class QueryType
 * @package Demo\Schema\Types
 */
class QueryType extends ObjectType
{
    /**
     * QueryType constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'description' => 'A simple blog API',
            'fields' => [
                'author'    => Fields\Author::getField(),
                'authors'   => Fields\Authors::getField(),
                'post'      => Fields\Post::getField(),
                'posts'     => Fields\Posts::getField(),
                'comment'   => Fields\Comment::getField(),
                'comments'  => Fields\Comments::getField(),
            ]
        ];

        parent::__construct($config);
    }
}
