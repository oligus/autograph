<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class Artists
 * @package Autograph\Tests\Application\Schema\Types
 */
class Artists extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Artists',
            'fields' => function (): array {
                return [
                    'nodes' => [
                        'type' => TypeManager::listOf(TypeManager::get('Artist'))
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}
