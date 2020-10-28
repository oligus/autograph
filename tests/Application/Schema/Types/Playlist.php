<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Autograph\Tests\Application\Schema\Fields\Artist;

/**
 * Class Playlist
 * @package Autograph\Tests\Application\Schema\Types
 */
class Playlist extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Playlist',
            'fields' => function (): array {
                return [
                    'id' => TypeManager::id(),
                    'name' => TypeManager::string()
                ];
            }
        ];

        parent::__construct($config);
    }
}
