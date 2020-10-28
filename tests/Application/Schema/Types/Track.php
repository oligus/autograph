<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Autograph\Tests\Application\Schema\Fields\Album;
use Autograph\Tests\Application\Schema\Fields\MediaType;
use Autograph\Tests\Application\Schema\Fields\Genre;

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
                    'album' => (new Album())->getField(),
                    'mediaType' => (new MediaType())->getField(),
                    'genre' => (new Genre())->getField()
                ];
            }
        ];

        parent::__construct($config);
    }
}
