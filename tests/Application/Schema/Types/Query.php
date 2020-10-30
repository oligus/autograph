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
                    'album' => (new Fields\Album())->getField(),
                    'albums' => (new Fields\Albums())->getField(),
                    'artist' => (new Fields\Artist())->getField(),
                    'artists' => (new Fields\Artists())->getField(),
                    'customer' => (new Fields\Customer())->getField(),
                    'employee' => (new Fields\Employee())->getField(),
                    'employees' => (new Fields\Employees())->getField(),
                    'genre' => (new Fields\Genre())->getField(),
                    'genres' => (new Fields\Genres())->getField(),
                    'mediaType' => (new Fields\MediaType())->getField(),
                    'mediaTypes' => (new Fields\MediaTypes())->getField(),
                    'playlist' => (new Fields\Playlist())->getField(),
                    'playlists' => (new Fields\Playlists())->getField(),
                    'track' => (new Fields\Track())->getField(),
                    'tracks' => (new Fields\Tracks())->getField(),
                ];
            }
        ]);
    }
}
