<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class Tracks
 * @package Autograph\Tests\Application\Schema\Types
 */
class Tracks extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Tracks',
            'fields' => function (): array {
                return [
                    'nodes' => [
                        'type' => TypeManager::listOf(TypeManager::get('Track'))
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}
