<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\Fields\Artists;
use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Exception;

/**
 * Class Album
 * @package Autograph\Demo\Schema\Types
 */
class Album extends ObjectType
{
    /**
     * Option constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Album',
            'description' => 'Album',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'id' => TypeManager::id(),
                    'title' => TypeManager::string(),
                    'artist' => Artists::getField()
                ];
            }
        ];

        parent::__construct($config);
    }
}
