<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types\Input;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\InputObjectType;
use Exception;

/**
 * Class UpdatePlayListInput
 * @package Autograph\Demo\Schema\Types\Input
 */
class UpdatePlayListInput extends InputObjectType
{
    /**
     * CreatePlayListInput constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'UpdatePlayListInput',
            'description' => 'PlayList input type',
            'fields' => [
                'id' => TypeManager::nonNull(TypeManager::id()),
                'name' => TypeManager::string()
            ]
        ];

        parent::__construct($config);
    }
}
