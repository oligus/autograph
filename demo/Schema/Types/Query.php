<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\Fields\Genres;
use Autograph\Demo\Schema\Fields\MediaTypes;
use Autograph\Demo\Schema\Fields\PlayLists;
use Autograph\Demo\Schema\Fields\Artists;
use Autograph\Demo\Schema\Fields\Albums;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class Query
 * @package Autograph\Demo\Schema\Types
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
                    'genres' => (new Genres())->getField(),
                    'mediaTypes' => (new MediaTypes())->getField(),
                    'playLists' => (new PlayLists())->getField(),
                    'artists' => (new Artists())->getField(),
                    'albums' => (new Albums())->getField()
                ];
            }
        ]);
    }
}
