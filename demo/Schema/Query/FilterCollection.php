<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Query;

use Doctrine\Common\Collections\ArrayCollection;

// @phan-file-suppress PhanPluginUnknownMethodParamType

/**
 * Class FilterCollection
 * @package Autograph\Demo\Schema\Query
 */
class FilterCollection extends ArrayCollection
{
    public function add($element): void
    {
        if ($element instanceof Filter) {
            $key = $element->getName();

            if (!$this->containsKey($key)) {
                $this->set($key, $element->getFilters());
            }
        }
    }
}
