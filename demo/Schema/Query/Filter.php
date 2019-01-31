<?php declare(strict_types=1);

namespace Autograph\Demo\Schema\Query;

use GraphQL\Type\Definition\InputObjectType;

/**
 * Class Filters
 * @package CM\Schema\Query
 */
class Filter
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $fields = [];

    /**
     * @var array
     */
    private $defaults = [];

    /**
     * Filters constructor.
     */
    private function __construct() { }

    /**
     * @param string $name
     * @return Filters
     */
    public static function create(string $name): self
    {
        $filter = new self();
        $filter->name = $name;
        $filter->fields = [];
        $filter->defaults = [];

        return $filter;
    }

    public function getFilters()
    {
        $filterType = new InputObjectType([
            'name' => $this->name,
            'fields' => $this->fields
        ]);

        $filters = [
            'type' => $filterType,
            'defaultValue' => $this->defaults
        ];

        return $filters;
    }

    /**
     * @param string $name
     * @param array $values
     * @throws \Exception
     */
    public function addField(string $name, array $values = [])
    {
        if(array_key_exists($name, $this->fields)) {
            throw new \Exception('Filter with name [' . $name . '] has already been added');
        }

        $this->fields[$name] = $values;
    }

    /**
     * @param string $name
     * @param array $values
     * @throws \Exception
     */
    public function addDefault(string $name, array $values = [])
    {
        if(array_key_exists($name, $this->fields)) {
            throw new \Exception('Default with name [' . $name . '] has already been added');
        }

        $this->defaults[$name] = $values;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}