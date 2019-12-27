<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Demo\Database\Repositories\CommonRepository;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Database\Entities\Albums as AlbumsEntity;
use Autograph\Context;
use Autograph\Manager;
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
 * Class Albums
 * @package Autograph\Demo\Schema\Fields
 */
class Albums
{
    /**
     * @return array<string,mixed>|null
     * @throws Exception
     */
    public function getField(): ?array
    {
        /** @var FilterInputCollection $filterCollection */
        $filterCollection = Manager::getInstance()->getFilterCollection();

        $filter = FilterInput::create('AlbumsFilters');
        $filter->addField('id', ['type' => TypeManager::id()]);
        $filter->addField('title', ['type' => TypeManager::string()]);

        $filterCollection->add($filter);

        return [
            'type' => TypeManager::get('Albums'),
            'args' => [
                'filter' => $filterCollection->get('AlbumsFilters'),
                'first' => TypeManager::int(),
                'after' => TypeManager::int(),
            ],
            /**
             * @param mixed $value
             * @param array<string,mixed> $args
             * @return array<array>|null
             * @throws \Doctrine\ORM\NonUniqueResultException
             */
            'resolve' => function ($value, array $args, Context $context, ResolveInfo $resolveInfo): ?array {
                $arguments = new Arguments($args);
                return $this->resolve($value, $arguments, $context, $resolveInfo);
            }
        ];
    }

    /**
     * @param $value
     * @param array $args
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

        if (!empty($value) && array_key_exists('albums', $value)) {
            $albums = $value['albums'];

            if($albums instanceof Collection) {
                $filter = new CollectionFilter($albums, $arguments);
                $albums = $filter->getFilteredCollection();
                $totalCount = $filter->getTotalCount();
                $count = $filter->getCount();
            }
        } else {
            $albums = $this->getData($arguments->getArgs());
            $totalCount = $this->getCount();
            $count = count($albums);
        }

        $nodes = [];

        /** @var AlbumsEntity $album */
        foreach ($albums as $album) {
            $nodes[] = (new Album())->resolve(['album' => $album], [], $context, $resolveInfo);
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
        $repository = Manager::getInstance()->getEm()->getRepository(AlbumsEntity::class);
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
        $repository = Manager::getInstance()->getEm()->getRepository(AlbumsEntity::class);
        return $repository->getCount();
    }
}
