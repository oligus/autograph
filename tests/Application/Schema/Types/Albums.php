<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class Albums
 * @package Autograph\Tests\Application\Schema\Types
 */
class Albums extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Albums',
            'fields' => function (): array {
                return [
                    'nodes' => [
                        'type' => TypeManager::listOf(TypeManager::get('Album'))
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}
