<?php declare(strict_types=1);

namespace Autograph\Query;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

/**
 * Class CollectionFilter
 * @package Autograph\Query
 */
class CollectionFilter
{
    private Collection $collection;
    private Collection $filteredCollection;
    private Arguments $arguments;
    private int $totalCount = 0;
    private int $count = 0;

    public function __construct(Collection $collection, Arguments $arguments)
    {
        $this->arguments = $arguments;
        $this->collection = $collection;
        $this->totalCount = $this->collection->count();
        $this->filteredCollection = $this->calculate();
    }

    private function calculate()
    {
        $criteria = new Criteria();

        $criteria->setFirstResult($this->arguments->getAfter());

        if(!empty($this->arguments->getFirst())) {
            $criteria->setMaxResults($this->arguments->getFirst());
        }

        $expr = $criteria::expr();

        foreach($this->arguments->getFilter() as $field => $value) {
            $expression = $expr->contains($field, $value);
            $criteria->andWhere($expression);
        }

        /** @var Collection $filteredCollection */
        $filteredCollection = $this->collection->matching($criteria);

        $this->count = $filteredCollection->count();

        return $filteredCollection;
    }

    public function getCollection(): Collection
    {
        return $this->collection;
    }

    public function getFilteredCollection(): Collection
    {
        return $this->filteredCollection;
    }

    public function getArguments(): Arguments
    {
        return $this->arguments;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    public function getCount(): int
    {
        return $this->count;
    }
}
