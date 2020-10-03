<?php declare(strict_types=1);

namespace Autograph\GraphQL;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class Query extends ObjectType
{
    /**
     * QueryType constructor.
     */
    public function __construct()
    {
        parent::__construct([
            'name' => 'Query',
            'description' => 'Stimplify Query fields',

            'fields' => function (): array {
                return [
                    'Category' =>
                        [
                            'type' => TypeManager::get('Category'),
                            'args' => ['id' => TypeManager::id()],
                            'resolve' =>  EntityResolver::resolve(),
                        ]
                ];
            }
        ]);
    }
}
