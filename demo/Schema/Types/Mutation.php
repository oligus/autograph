<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Types;

use Autograph\Demo\Schema\Mutations\Album;
use Autograph\Demo\Schema\Mutations\Artist;
use Autograph\Demo\Schema\Mutations\Genre;
use Autograph\Demo\Schema\Mutations\MediaType;
use Autograph\Demo\Schema\Mutations\PlayList;
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
                    'createGenre' => (new Genre())->create(),
                    'updateGenre' => (new Genre())->update(),
                    'deleteGenre' => (new Genre())->delete(),

                    'createMediaType' => (new MediaType())->create(),
                    'updateMediaType' => (new MediaType())->update(),
                    'deleteMediaType' => (new MediaType())->delete(),

                    'createPlayList' => (new PlayList())->create(),
                    'updatePlayList' => (new PlayList())->update(),
                    'deletePlayList' => (new PlayList())->delete(),

                    'createArtist' => (new Artist())->create(),
                    'updateArtist' => (new Artist())->update(),
                    'deleteArtist' => (new Artist())->delete(),

                    'createAlbum' => (new Album())->create(),
                    'updateAlbum' => (new Album())->update(),
                    'deleteAlbum' => (new Album())->delete(),
                ];
            }
        ];

        parent::__construct($config);
    }
}
