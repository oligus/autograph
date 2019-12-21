<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Fields;

use Autograph\Demo\Database\Repositories\CommonRepository;
use Autograph\Demo\Manager;
use Autograph\Demo\Schema\TypeManager;
use Autograph\Demo\Database\Entities\MediaTypes as MediaTypesEntity;
use Autograph\Demo\Schema\Context;
use Autograph\Demo\Schema\Query\Filter;
use Autograph\Demo\Schema\Query\FilterCollection;
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
    public function __construct()
    {

    }

    /**
     * @return array<string,mixed>|null
     * @throws Exception
     */
    public function getField(): ?array
    {
        /** @var FilterCollection $filterCollection */
        $filterCollection = Manager::getInstance()->getFilterCollection();

        $filter = Filter::create('MediaTypesFilters');
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
                return $this->resolve($value, $args, $context, $resolveInfo);
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
     */
    public function resolve($value, array $args, Context $context, ResolveInfo $resolveInfo): ?array
    {
        if (!empty($value) && array_key_exists('mediaTypes', $value)) {
            $mediaTypes = $value['mediaTypes'];
        } else {
            $mediaTypes = $this->getData($args);
        }

        $totalCount = $this->getCount();

        $nodes = [];

        /** @var MediaTypesEntity $mediaType */
        foreach ($mediaTypes as $mediaType) {
            $nodes[] = [
                'id' => $mediaType->getId(),
                'name' => $mediaType->getName()
            ];
        }

        return [
            'totalCount' => $totalCount,
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
