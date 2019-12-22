<?php declare(strict_types=1);

namespace Autograph\Query;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class FilterCollection
 * @package Autograph\Query
 */
class FilterInputCollection extends ArrayCollection
{
    public function add($element): void
    {
        if ($element instanceof FilterInput) {
            $key = $element->getName();

            if (!$this->containsKey($key)) {
                $this->set($key, $element->getFilters());
            }
        }
    }
}
