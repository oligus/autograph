<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Exception;

/**
 * Class Track
 * @package Autograph\Demo\Schema\Type
 */
class Genre extends ObjectType
{
    /**
     * Option constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Genre',
            'description' => 'Genre',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'id' => TypeManager::id(),
                    'name' => TypeManager::string()
                ];
            }
        ];

        parent::__construct($config);
    }
}
