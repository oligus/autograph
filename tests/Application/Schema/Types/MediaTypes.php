<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class MediaTypes
 * @package Autograph\Tests\Application\Schema\Types
 */
class MediaTypes extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'MediaTypes',
            'fields' => function (): array {
                return [
                    'nodes' => [
                        'type' => TypeManager::listOf(TypeManager::get('MediaType'))
                    ]
                ];
            },
        ];

        parent::__construct($config);
    }
}
