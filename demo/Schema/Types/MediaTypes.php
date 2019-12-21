<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Exception;

/**
 * Class Tracks
 * @package Autograph\Demo\Schema\Type
 */
class MediaTypes extends ObjectType
{
    /**
     * Option constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'MediaTypes',
            'description' => 'Media Types',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'totalCount' =>  TypeManager::int(),
                    'nodes' => TypeManager::listOf(TypeManager::get('MediaType')),
                ];
            }
        ];

        parent::__construct($config);
    }
}
