<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class Playlists
 * @package Autograph\Tests\Application\Schema\Types
 */
class Playlists extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Playlists',
            'fields' => function (): array {
                return [
                    'nodes' => [
                        'type' => TypeManager::listOf(TypeManager::get('Playlist'))
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}
