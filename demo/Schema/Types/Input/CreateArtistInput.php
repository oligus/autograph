<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types\Input;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\InputObjectType;
use Exception;

/**
 * Class CreateArtistInput
 * @package Autograph\Demo\Schema\Types\Input
 */
class CreateArtistInput extends InputObjectType
{
    /**
     * CreateGenreInput constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'CreateArtistInput',
            'description' => 'Create Artist input type',
            'fields' => [
                'name' => TypeManager::string()
            ]
        ];

        parent::__construct($config);
    }
}
