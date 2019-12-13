<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\Fields\Album;
use Autograph\Demo\Schema\Fields\Albums;
use Autograph\Demo\Schema\Fields\Artist;
use Autograph\Demo\Schema\Fields\Artists;
use Autograph\Demo\Schema\Fields\Genre;
use Autograph\Demo\Schema\Fields\Genres;
use Autograph\Demo\Schema\Fields\Track;
use Autograph\Demo\Schema\Fields\Tracks;
use GraphQL\Type\Definition\ObjectType;
use Exception;

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
                    'album' => Album::getField(),
                    'albums' => Albums::getField(),
                    'artist' => Artist::getField(),
                    'artists' => Artists::getField(),
                    'genre' => Genre::getField(),
                    'genres' => Genres::getField(),
                    'track' => Track::getField(),
                    'tracks' => Tracks::getField(),
                ];
            }
        ]);
    }
}
