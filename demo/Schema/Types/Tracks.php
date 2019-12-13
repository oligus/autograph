<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Exception;

/**
 * Class Tracks
 * @package Autograph\Demo\Schema\Type
 */
class Tracks extends ObjectType
{
    /**
     * Option constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Tracks',
            'description' => 'Tracks',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'count' =>  TypeManager::int(),
                    'nodes' => TypeManager::listOf(TypeManager::get('Track'))
                ];
            }
        ];

        parent::__construct($config);
    }
}
