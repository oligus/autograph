<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types\Input;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\InputObjectType;
use Exception;

/**
 * Class UpdateArtistInput
 * @package Autograph\Demo\Schema\Types\Input
 */
class UpdateArtistInput extends InputObjectType
{
    /**
     * CreateGenreInput constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'UpdateArtistInput',
            'description' => 'Artist input type',
            'fields' => [
                'id' => TypeManager::nonNull(TypeManager::id()),
                'name' => TypeManager::string()
            ]
        ];

        parent::__construct($config);
    }
}
