<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types\Input;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\InputObjectType;
use Exception;

/**
 * Class CreateAlbumInput
 * @package Autograph\Demo\Schema\Types\Input
 */
class CreateAlbumInput extends InputObjectType
{
    /**
     * CreateGenreInput constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'CreateAlbumInput',
            'description' => 'Create Album input type',
            'fields' => [
                'title' => TypeManager::string(),
                'artist' => TypeManager::id()
            ]
        ];

        parent::__construct($config);
    }
}
