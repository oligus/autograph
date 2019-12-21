<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types\Input;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\InputObjectType;
use Exception;

/**
 * Class CreateMediaTypeInput
 * @package Autograph\Demo\Schema\Types\Input
 */
class CreateMediaTypeInput extends InputObjectType
{
    /**
     * CreateGenreInput constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'CreateMediaTypeInput',
            'description' => 'Media type input type',
            'fields' => [
                'name' => TypeManager::string()
            ]
        ];

        parent::__construct($config);
    }
}
