<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Demo\Database\Repositories\CommonRepository;
use Autograph\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Database\Entities\MediaTypes as MediaTypesEntity;
use Autograph\Demo\Schema\Context;
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
class MediaTypes
{
    /**
     * @return array<string,mixed>|null
     * @throws Exception
     */
    public function getField(): ?array
    {
        /** @var FilterInputCollection $filterCollection */
        $filterCollection = Manager::getInstance()->getFilterCollection();

        $filter = FilterInput::create('MediaTypesFilters');
        $filter->addField('id', ['type' => TypeManager::id()]);
        $filter->addField('name', ['type' => TypeManager::string()]);

        $filterCollection->add($filter);

        return [
            'type' => TypeManager::get('MediaTypes'),
            'args' => [
                'filter' => $filterCollection->get('MediaTypesFilters'),
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

        if (!empty($value) && array_key_exists('mediaTypes', $value)) {
            $mediaTypes = $value['mediaTypes'];

            if($mediaTypes instanceof Collection) {
                $filter = new CollectionFilter($mediaTypes, $arguments);
                $mediaTypes = $filter->getFilteredCollection();
                $totalCount = $filter->getTotalCount();
                $count = $mediaTypes->count();
            }
        } else {
            $mediaTypes = $this->getData($arguments->getArgs());
            $totalCount = $this->getCount();
            $count = count($mediaTypes);
        }

        $nodes = [];

        /** @var MediaTypesEntity $mediaType */
        foreach ($mediaTypes as $mediaType) {
            $nodes[] = (new MediaType())->resolve(['mediaType' => $mediaType], [], $context, $resolveInfo);
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
        $repository = Manager::getInstance()->getEm()->getRepository(MediaTypesEntity::class);
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
        $repository = Manager::getInstance()->getEm()->getRepository(MediaTypesEntity::class);
        return $repository->getCount();
    }
}
