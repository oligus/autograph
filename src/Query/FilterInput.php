<?php declare(strict_types=1);

namespace Autograph\Query;

use GraphQL\Type\Definition\InputObjectType;
use Exception;

/**
 * Class FilterInput
 * @package Autograph\Query
 */
class FilterInput
{
    private string $name;
    private array $fields = [];
    private array $defaults = [];

    public static function create(string $name): self
    {
        $filter = new self();
        $filter->name = $name;
        $filter->fields = [];
        $filter->defaults = [];

        return $filter;
    }

    public function getFilters(): array
    {
        $filterType = new InputObjectType([
            'name' => $this->name,
            'fields' => $this->fields
        ]);

        return [
            'type' => $filterType,
            'defaultValue' => $this->defaults
        ];
    }

    /**
     * @param array<mixed> $values
     * @throws Exception
     */
    public function addField(string $name, array $values = []): void
    {
        if (array_key_exists($name, $this->fields)) {
            throw new Exception('Filter with name [' . $name . '] has already been added');
        }

        $this->fields[$name] = $values;
    }

    /**
     * @param array<mixed> $values
     * @throws Exception
     */
    public function addDefault(string $name, array $values = []): void
    {
        if (array_key_exists($name, $this->fields)) {
            throw new Exception('Default with name [' . $name . '] has already been added');
        }

        $this->defaults[$name] = $values;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
