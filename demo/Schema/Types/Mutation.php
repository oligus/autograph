<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use GraphQL\Type\Definition\ObjectType;
use Exception;

/**
 * Class Mutation
 * @package Stimplify\Schema\Type
 */
class Mutation extends ObjectType
{
    /**
     * Mutation constructor.
     */
    public function __construct()
    {
        $config = [
            'name' => 'Mutation',
            /**
             * @return array<string,array<string,mixed>>
             * @throws Exception
             */
            'fields' => function (): array {
                return [

                ];
            }
        ];

        parent::__construct($config);
    }
}
