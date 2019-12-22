<?php declare(strict_types=1);

namespace Autograph\Query;

/**
 * Class Arguments
 * @package Autograph\Query
 */
class Arguments
{
    private array $args;

    private ?int $first = null;
    private int $after = 0;

    private array $filter = [];

    public function __construct(array $args)
    {
        $this->args = $args;

        if(array_key_exists('first', $args)) {
            $this->first = (int) $args['first'];
        }

        if(array_key_exists('after', $args)) {
            $this->after = (int) $args['after'];
        }

        if(array_key_exists('filter', $args) && is_array($args['filter'])) {
            $this->filter = $args['filter'];
        }
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function getFirst(): ?int
    {
        return $this->first;
    }

    public function getAfter(): int
    {
        return $this->after;
    }

    public function getFilter(): array
    {
        return $this->filter;
    }
}
