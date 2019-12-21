<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types\Input;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\InputObjectType;
use Exception;

/**
 * Class UpdateMediaTypeInput
 * @package Autograph\Demo\Schema\Types\Input
 */
class UpdateMediaTypeInput extends InputObjectType
{
    /**
     * CreateGenreInput constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'UpdateMediaTypeInput',
            'description' => 'Media type input type',
            'fields' => [
                'id' => TypeManager::nonNull(TypeManager::id()),
                'name' => TypeManager::string()
            ]
        ];

        parent::__construct($config);
    }
}
