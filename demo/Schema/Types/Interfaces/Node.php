<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types\Interfaces;

use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\InterfaceType;
use Exception;

/**
 * Class Node
 * @package Autograph\Demo\Schema\Types\Interfaces
 */
class Node extends InterfaceType
{
    /**
     * Node constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Node',
            'description' => 'Node interface',
            'fields' => [
                'id' => [
                    'type' => TypeManager::nonNull(TypeManager::id()),
                    'description' => 'The id of the node.',
                ],
            ],
        ];

        parent::__construct($config);
    }
}
