<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Schema\Fields\Albums;
use GraphQL\Type\Definition\ObjectType;
use Exception;

/**
 * Class Artist
 * @package Autograph\Demo\Schema\Types
 */
class Artist extends ObjectType
{
    /**
     * Option constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Artist',
            'description' => 'Artist',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'id' => TypeManager::id(),
                    'name' => TypeManager::string(),
                    'albums' => (new Albums())->getField()
                ];
            }
        ];

        parent::__construct($config);
    }
}
