<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Demo\Database\Repositories\CommonRepository;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Database\Entities\Artists as ArtistsEntity;
use Autograph\Demo\Schema\Context;
use Autograph\Manager;
use Autograph\Query\Arguments;
use Autograph\Query\CollectionFilter;
use Autograph\Query\FilterInput;
use Autograph\Query\FilterInputCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use GraphQL\Type\Definition\ResolveInfo;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;

/**
 * Class Artists
 * @package Autograph\Demo\Schema\Fields
 */
class Artists
{
    /**
     * @return array<string,mixed>|null
     * @throws Exception
     */
    public function getField(): ?array
    {
        /** @var FilterInputCollection $filterCollection */
        $filterCollection = Manager::getInstance()->getFilterCollection();

        $filter = FilterInput::create('ArtistsFilters');
        $filter->addField('id', ['type' => TypeManager::id()]);
        $filter->addField('name', ['type' => TypeManager::string()]);
        $filterCollection->add($filter);

        return [
            'type' => TypeManager::get('Artists'),
            'interfaces' => [
                TypeManager::getInterface('Node'),
            ],
            'args' => [
                'filter' => $filterCollection->get('ArtistsFilters'),
                'first' => TypeManager::int(),
                'after' => TypeManager::int()
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

        if (!empty($value) && array_key_exists('artists', $value)) {
            $artists = $value['artists'];

            if($artists instanceof Collection) {
                $filter = new CollectionFilter($artists, $arguments);
                $artists = $filter->getFilteredCollection();
                $totalCount = $filter->getTotalCount();
                $count = $artists->count();
            }
        } else {
            $artists = $this->getData($arguments->getArgs());
            $totalCount = $this->getCount();
            $count = $artists->count();
        }

        $nodes = [];

        /** @var ArtistsEntity $artist */
        foreach ($artists as $artist) {
            $nodes[] = (new Artist())->resolve(['artist' => $artist], [], $context, $resolveInfo);
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
        $repository = Manager::getInstance()->getEm()->getRepository(ArtistsEntity::class);
        return new ArrayCollection($repository->filter($args));
    }

    /**
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public static function getCount(): int
    {
        /** @var CommonRepository $repository */
        $repository = Manager::getInstance()->getEm()->getRepository(ArtistsEntity::class);
        return $repository->getCount();
    }
}
