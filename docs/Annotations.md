# Annotations

[@ObjectField](docs/Annotations.md#ojectfield)<br />
[@ObjectType](docs/Annotations.md#objecttype)<br />

## @ObjectField

Optional attributes:
* **name** Name of the GraphQL field, if omitted will be set to property name
* **description** GraphQL field description.
* **type** GraphQL type, eg `String`, `Int!`

Examples:

```php
use Autograph\Map\Annotations as AUG;
...

/**
  * @ORM\Column(name="CategoryName", type="text", nullable=false)
  * @AUG\ObjectField(name="name", type="String!", description="Name of category")
  */
protected string $name;
```

## @ObjectType

Optional attributes:
* **name** Name of the GraphQL object type, if omitted will be set to current class name
* **description** GraphQL object type description.

Examples:

```php
use Autograph\Map\Annotations as AUG;

/**
 * @ORM\Entity
 * @ORM\Table(name="Categories")
 * @AUG\ObjectType(name="Category", description="A category")
 */
class Categories
...
```


