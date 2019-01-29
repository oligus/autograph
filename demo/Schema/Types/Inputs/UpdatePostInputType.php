<?php declare(strict_types=1);

namespace Demo\Schema\Types\Inputs;

use Demo\Schema\TypeManager;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class UpdatePostInputType
 * @package Demo\Schema\Types\Inputs
 */
class UpdatePostInputType extends InputObjectType
{
    /**
     * UpdatePostInputType constructor.
     */
    public function __construct()
    {
        $config = [
            'name' => 'UpdatePostInputType',
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
            ]
        ];

        parent::__construct($config);
    }
}
