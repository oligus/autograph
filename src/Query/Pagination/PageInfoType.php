<?php declare(strict_types=1);

namespace Autograph\Query\Pagination;

use Autograph\Demo\Schema\Context;
use Autograph\Demo\Schema\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Exception;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class PageInfoType
 * @package Autograph\Query\Pagination\PageInfo
 */
class PageInfoType extends ObjectType
{
    /**
     * Option constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'PageInfo',
            'description' => 'Page info',
            /**
             * @return array<string,mixed>
             * @throws Exception
             */
            'fields' => function (): array {
                return [
                    'hasNextPage' =>  TypeManager::nonNull(TypeManager::boolean()),
                    'hasPreviousPage' => TypeManager::nonNull(TypeManager::boolean()),
                    'startCursor' =>  TypeManager::nonNull(TypeManager::string()),
                    'endCursor' =>  TypeManager::nonNull(TypeManager::string()),
                ];
            }
        ];

        parent::__construct($config);
    }
}
