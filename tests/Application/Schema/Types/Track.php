<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\Schema\Fields;
use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class Track
 * @package Autograph\Tests\Application\Schema\Types
 */
class Track extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Track',
            'fields' => function (): array {
                return [
                    'id' => TypeManager::id(),
                    'name' => TypeManager::string(),
                    'composer' => TypeManager::string(),
                    'milliseconds' => TypeManager::string(),
                    'bytes' => TypeManager::string(),
                    'unitPrice' => TypeManager::string(),
                    'album' => (new Fields\Album())->getField(),
                    'mediaType' => (new Fields\MediaType())->getField(),
                    'genre' => (new Fields\Genre())->getField(),
                    'playlists' => (new Fields\Playlists())->getField()
                ];
            }
        ];

        parent::__construct($config);
    }
}
