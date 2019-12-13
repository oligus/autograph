<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Demo\Database\Repositories\CommonRepository;
use Autograph\Demo\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Database\Entities\Tracks as TracksEntity;
use Autograph\Demo\Schema\AppContext;
use Autograph\Demo\Schema\Query\Filter;
use Autograph\Demo\Schema\Query\FilterCollection;
use GraphQL\Type\Definition\ResolveInfo;
use Exception;

/**
 * Class Tracks
 * @package Autorgraph\Demo\Schema\Fields
 */
class Tracks
{
    /**
     * @return array<string,mixed>|null
     * @throws Exception
     */
    public static function getField(): ?array
    {
        /** @var FilterCollection $filterCollection */
        $filterCollection = Manager::getInstance()->getFilterCollection();

        $filter = Filter::create('TracksFilters');
        $filter->addField('id', ['type' => TypeManager::id()]);
        $filter->addField('name', ['type' => TypeManager::string()]);

        $filterCollection->add($filter);

        return [
            'type' => TypeManager::get('Tracks'),
            'args' => [
                'filter' => $filterCollection->get('TracksFilters'),
                'first' => [
                    'type' => TypeManager::int()
                ],
                'offset' => [
                    'type' => TypeManager::int(),
                    'defaultValue' => 0
                ],
                'after' => [
                    'type' => TypeManager::int(),
                    'defaultValue' => 0
                ]
            ],
            /**
             * @param mixed $value
             * @param array<string,mixed> $args
             * @return array<array>|null
             * @throws \Doctrine\ORM\NonUniqueResultException
             */
            'resolve' => function ($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo): ?array {
                return self::resolve($value, $args, $appContext, $resolveInfo);
            }
        ];
    }

    /**
     * @param mixed $value
     * @param array<string,mixed> $args
     * @param AppContext $appContext
     * @param ResolveInfo $resolveInfo
     * @return array<string,mixed>|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @suppress PhanUnusedPublicMethodParameter
     */
    public static function resolve($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo): ?array
    {
        if (!empty($value) && array_key_exists('tracks', $value)) {
            $tracks = $value['tracks'];
        } else {
            $tracks = self::getData($args);
        }

        $nodes = [];


        /** @var TracksEntity $track */
        foreach ($tracks as $track) {
            $nodes[] = [
                'id' => $track->getId(),
                'name' => $track->getName(),
                'albums' => $track->getAlbum(),
                'genres' => $track->getGenre(),
                'composer' => $track->getComposer(),
                'milliseconds' => $track->getMilliseconds(),
                'price' => $track->getPrice(),
            ];
        }

        return [
            'count' => self::getCount(),
            'nodes' => $nodes
        ];
    }

    /**
     * @param array<string,mixed> $args
     * @return mixed
     */
    public static function getData(array $args)
    {
        /** @var CommonRepository $repository */
        $repository = Manager::getInstance()->getEm()->getRepository(TracksEntity::class);
        return $repository->filter($args);
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public static function getCount(): int
    {
        /** @var CommonRepository $repository */
        $repository = Manager::getInstance()->getEm()->getRepository(TracksEntity::class);
        return $repository->getCount();
    }
}
