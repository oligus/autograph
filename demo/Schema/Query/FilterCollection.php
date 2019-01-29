<?php declare(strict_types=1);

namespace Demo\Schema\Query;

use Doctrine\Common\Collections\ArrayCollection;

class FilterCollection extends ArrayCollection
{
    /**
     * @param $element
     * @return bool|void
     */
    public function add($element)
    {
        if($element instanceof Filter) {
            $key = $element->getName();

            if(!$this->containsKey($key)) {
                $this->set($key, $element->getFilters());
            }
        }
    }
}