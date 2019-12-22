<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types\Input;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\InputObjectType;
use Exception;

/**
 * Class CreatePlayListInput
 * @package Autograph\Demo\Schema\Types\Input
 */
class CreatePlayListInput extends InputObjectType
{
    /**
     * CreatePlayListInput constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'CreatePlayListInput',
            'description' => 'PlayList input type',
            'fields' => [
                'name' => TypeManager::string()
            ]
        ];

        parent::__construct($config);
    }
}
