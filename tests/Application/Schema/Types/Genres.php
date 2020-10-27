<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class Genres
 * @package Autograph\Tests\Application\Schema\Types
 */
class Genres extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Genres',
            'fields' => function (): array {
                return [
                    'nodes' => [
                        'type' => TypeManager::listOf(TypeManager::get('Genre'))
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}
