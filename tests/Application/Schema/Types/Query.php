<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\Schema\Fields;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class Query
 * @package Autograph\Tests\Application\Schema\Types
 */
class Query extends ObjectType
{
    /**
     * QueryType constructor.
     */
    public function __construct()
    {
        parent::__construct([
            'name' => 'Query',
            'description' => 'Query fields',
            'fields' => function (): array {
                return [
                    'artist' => (new Fields\Artist())->getField(),
                    'artists' => (new Fields\Artists())->getField(),
                    'genre' => (new Fields\Genre())->getField(),
                    'genres' => (new Fields\Genres())->getField(),
                    'mediaType' => (new Fields\MediaType())->getField(),
                    'mediaTypes' => (new Fields\MediaTypes())->getField()
                ];
            }
        ]);
    }
}
