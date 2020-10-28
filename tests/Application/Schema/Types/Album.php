<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Autograph\Tests\Application\Schema\Fields\Artist;

/**
 * Class Album
 * @package Autograph\Tests\Application\Schema\Types
 */
class Album extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Album',
            'fields' => function (): array {
                return [
                    'id' => TypeManager::id(),
                    'title' => TypeManager::string(),
                    'artist' => (new Artist())->getField()
                ];
            }
        ];

        parent::__construct($config);
    }
}
