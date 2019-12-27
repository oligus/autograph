<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Exception;

/**
 * Class Artists
 * @package Autograph\Demo\Schema\Types
 */
class Artists extends ObjectType
{
    /**
     * Option constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Artists',
            'description' => 'Artists',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'totalCount' =>  TypeManager::int(),
                    'count' =>  TypeManager::int(),
                    'nodes' => TypeManager::listOf(TypeManager::get('Artist')),
                ];
            }
        ];

        parent::__construct($config);
    }
}
