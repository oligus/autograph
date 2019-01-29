<?php declare(strict_types=1);

namespace Demo\Schema\Types;

use GraphQL\Type\Definition\ObjectType;
use Demo\Schema\TypeManager;
use Demo\Schema\Fields\Posts;

/**
 * Class Author
 * @package Demo\Schema\Types
 */
class Author extends ObjectType
{
    /**
     * Author constructor.
     */
    public function __construct()
    {
        $config = [
            'name' => 'Author',
            'description' => 'Author of a post, comment or even both.',
            'fields' => function() {
                return [
                    'id' => [
                        'type' => TypeManager::id(),
                        'description' => 'A unique id of the author'
                    ],
                    'name' => [
                        'type' => TypeManager::string(),
                        'description' => 'Name of the author'
                    ],
                    'posts' => Posts::getField()
                ];
            }
        ];

        parent::__construct($config);
    }
}
