<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Autograph;
use Autograph\Demo\Database\Repositories\CommonRepository;
use Autograph\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Database\Entities\Genres as GenresEntity;
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
 * Class Genres
 * @package Autograph\Demo\Schema\Fields
 */
class Genres
{
    /**
     * @return array<string,mixed>|null
     * @throws Exception
     */
    public function getField(): ?array
    {
        /** @var FilterInputCollection $filterCollection */
        $filterCollection = Autograph::getInstance()->getFilterCollection();

        $filter = FilterInput::create('GenresFilters');
        $filter->addField('id', ['type' => TypeManager::id()]);
        $filter->addField('name', ['type' => TypeManager::string()]);

        $filterCollection->add($filter);

        return [
            'type' => TypeManager::get('Genres'),
            'interfaces' => [
                TypeManager::getInterface('Node'),
            ],
            'args' => [
                'filter' => $filterCollection->get('GenresFilters'),
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

        if (!empty($value) && array_key_exists('genres', $value)) {
            $genres = $value['genres'];

            if($genres instanceof Collection) {
                $filter = new CollectionFilter($genres, $arguments);
                $genres = $filter->getFilteredCollection();
                $totalCount = $filter->getTotalCount();
                $count = $genres->count();
            }
        } else {
            $genres = $this->getData($arguments->getArgs());
            $totalCount = $this->getCount();
            $count = count($genres);
        }

        $nodes = [];

        /** @var GenresEntity $genre */
        foreach ($genres as $genre) {
            $nodes[] = (new Genre())->resolve(['genre' => $genre], [], $context, $resolveInfo);
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
        $repository = Autograph::getInstance()->getEm()->getRepository(GenresEntity::class);
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
        $repository = Autograph::getInstance()->getEm()->getRepository(GenresEntity::class);
        return $repository->getCount();
    }
}
