<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types\Inputs;

use Autograph\Demo\Schema\Fields\Field;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\InputObjectType;


/**
 * Class PostInputType
 * @package Autograph\Demo\Schema\Fields\Mutation
 */
class PostInputType extends InputObjectType
{
    /**
     * PostInputType constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'PostInputType',
            'description' => 'Post item input type',
            'fields' => [
                'title' => [
                    'type' => TypeManager::string(),
                    'description' => 'Post title'
                ],
                'content' => [
                    'type' => TypeManager::string(),
                    'description' => 'Post content'
                ],
                'authorId' => [
                    'type' => TypeManager::nonNull(TypeManager::id()),
                ]
            ]
        ];

        parent::__construct($config);
    }
}
