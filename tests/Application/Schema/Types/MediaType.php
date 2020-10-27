<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class MediaType
 * @package Autograph\Tests\Application\Schema\Types
 */
class MediaType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'MediaType',
            'fields' => function (): array {
                return [
                    'id' => TypeManager::id(),
                    'name' => TypeManager::string(),
                ];
            }
        ];

        parent::__construct($config);
    }
}
