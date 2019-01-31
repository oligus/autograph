<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Query;

use Doctrine\Common\Collections\Collection;

/**
 * Class FilterDoctrineCollection
 * @package Autograph\Demo\Schema\Query
 */
class FilterDoctrineCollection
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var array
     */
    private $args;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $length;

    /**
     * FilterDoctrineCollection constructor.
     * @param Collection $collection
     * @param array $args
     */
    public function __construct(Collection $collection, array $args = [])
    {
        $this->collection = $collection;
        $this->args = $args;
        $this->offset = (int) $args['after'];

        $this->length = count($this->collection) - $this->offset;

        if(array_key_exists('first', $args)) {
            $this->length = (int) $args['first'];
        }
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        $result = $this->collection->slice($this->offset, $this->length);
        return $result;
    }
}