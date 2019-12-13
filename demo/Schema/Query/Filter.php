<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Query;

use GraphQL\Type\Definition\InputObjectType;

/**
 * Class Filters
 * @package CX\Schema\Query
 */
class Filter
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array<string,array>
     */
    private $fields = [];

    /**
     * @var array<string,array>
     */
    private $defaults = [];

    /**
     * Filters constructor.
     * @phan-suppress PhanEmptyPrivateMethod
     */
    private function __construct()
    {
    }

    public static function create(string $name): self
    {
        $filter = new self();
        $filter->name = $name;
        $filter->fields = [];
        $filter->defaults = [];

        return $filter;
    }

    /**
     * @return array<string,mixed>
     */
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
     * @throws \Exception
     */
    public function addField(string $name, array $values = []): void
    {
        if (array_key_exists($name, $this->fields)) {
            throw new \Exception('Filter with name [' . $name . '] has already been added');
        }

        $this->fields[$name] = $values;
    }

    /**
     * @param array<mixed> $values
     * @throws \Exception
     */
    public function addDefault(string $name, array $values = []): void
    {
        if (array_key_exists($name, $this->fields)) {
            throw new \Exception('Default with name [' . $name . '] has already been added');
        }

        $this->defaults[$name] = $values;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getName(): string
    {
        return $this->name;
    }
}
