<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Exception;

/**
 * Class PlayLists
 * @package Autograph\Demo\Schema\Types
 */
class PlayLists extends ObjectType
{
    /**
     * Option constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'PlayLists',
            'description' => 'Play lists',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'totalCount' =>  TypeManager::int(),
                    'nodes' => TypeManager::listOf(TypeManager::get('PlayList')),
                ];
            }
        ];

        parent::__construct($config);
    }
}
