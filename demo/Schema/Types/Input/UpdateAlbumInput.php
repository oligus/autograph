<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types\Input;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\InputObjectType;
use Exception;

/**
 * Class UpdateAlbumInput
 * @package Autograph\Demo\Schema\Types\Input
 */
class UpdateAlbumInput extends InputObjectType
{
    /**
     * CreateGenreInput constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'UpdateAlbumInput',
            'description' => 'Album input type',
            'fields' => [
                'id' => TypeManager::nonNull(TypeManager::id()),
                'title' => TypeManager::string()
            ]
        ];

        parent::__construct($config);
    }
}
