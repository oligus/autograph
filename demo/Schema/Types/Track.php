<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Schema\Fields\Genre;
use GraphQL\Type\Definition\ObjectType;
use Exception;

/**
 * Class Track
 * @package Autograph\Demo\Schema\Type
 */
class Track extends ObjectType
{
    /**
     * Option constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Track',
            'description' => 'Track',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'id' => TypeManager::id(),
                    'name' => TypeManager::string(),
                    //'albums' => TypeManager::string(),
                    'genre' => Genre::getField(),
                    'composer' => TypeManager::string(),
                    'milliseconds' => TypeManager::int(),
                    'price' => TypeManager::float(),
                ];
            }
        ];

        parent::__construct($config);
    }
}
