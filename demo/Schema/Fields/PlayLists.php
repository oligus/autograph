<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Demo\Database\Repositories\CommonRepository;
use Autograph\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Database\Entities\Playlists as PlaylistsEntity;
use Autograph\Context;
use Autograph\Query\Arguments;
use Autograph\Query\CollectionFilter;
use Autograph\Query\FilterInput;
use Autograph\Query\FilterInputCollection;
use Doctrine\Common\Collections\Collection;
use GraphQL\Type\Definition\ResolveInfo;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;

/**
 * Class PlayLists
 * @package Autograph\Demo\Schema\Fields
 */
class PlayLists
{
    /**
     * @return array<string,mixed>|null
     * @throws Exception
     */
    public function getField(): ?array
    {
        /** @var FilterInputCollection $filterCollection */
        $filterCollection = Manager::getInstance()->getFilterCollection();

        $filter = FilterInput::create('PlayListsFilters');
        $filter->addField('id', ['type' => TypeManager::id()]);
        $filter->addField('name', ['type' => TypeManager::string()]);

        $filterCollection->add($filter);

        return [
            'type' => TypeManager::get('PlayLists'),
            'interfaces' => [
                TypeManager::getInterface('Node'),
            ],
            'args' => [
                'filter' => $filterCollection->get('PlayListsFilters'),
                'first' => TypeManager::int(),
                'offset' => TypeManager::int(),
                'after' => TypeManager::int(),
                'before' => TypeManager::int()
            ],
            /**
             * @param mixed $value
             * @param array<string,mixed> $args
             * @return array<array>|null
             * @throws \Doctrine\ORM\NonUniqueResultException
             */
            'resolve' => function ($value, array $args, Context $context, ResolveInfo $resolveInfo): ?array {
                return $this->resolve($value, new Arguments($args), $context, $resolveInfo);
            }
        ];
    }

    /**
     * @param $value
     * @param array $arguments
     * @param Context $context
     * @param ResolveInfo $resolveInfo
     * @return array|null
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function resolve($value, Arguments $arguments, Context $context, ResolveInfo $resolveInfo): ?array
    {
        $totalCount = 0;
        $count = 0;

        if (!empty($value) && array_key_exists('playLists', $value)) {
            $playLists = $value['playLists'];

            if($playLists instanceof Collection) {
                $filter = new CollectionFilter($playLists, $arguments);
                $playLists = $filter->getFilteredCollection();
                $totalCount = $filter->getTotalCount();
                $count = $playLists->count();
            }
        } else {
            $playLists = $this->getData($arguments->getArgs());
            $totalCount = $this->getCount();
            $count = count($playLists);
        }

        $nodes = [];

        /** @var PlaylistsEntity $playList */
        foreach ($playLists as $playList) {
            $nodes[] = (new PlayList())->resolve(['playList' => $playList], [], $context, $resolveInfo);
        }

        return [
            'totalCount' => $totalCount,
            'count' => $count,
            'nodes' => $nodes
        ];
    }

    /**
     * @param array<string,mixed> $args
     * @return mixed
     */
    public function getData(array $args)
    {
        /** @var CommonRepository $repository */
        $repository = Manager::getInstance()->getEm()->getRepository(PlaylistsEntity::class);
        return $repository->filter($args);
    }

    /**
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public static function getCount(): int
    {
        /** @var CommonRepository $repository */
        $repository = Manager::getInstance()->getEm()->getRepository(PlaylistsEntity::class);
        return $repository->getCount();
    }
}
