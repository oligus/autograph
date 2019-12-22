<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Exception;

/**
 * Class Albums
 * @package Autograph\Demo\Schema\Types
 */
class Albums extends ObjectType
{
    /**
     * Option constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Albums',
            'description' => 'Albums',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'totalCount' =>  TypeManager::int(),
                    'count' =>  TypeManager::int(),
                    'nodes' => TypeManager::listOf(TypeManager::get('Album')),
                ];
            }
        ];

        parent::__construct($config);
    }
}
