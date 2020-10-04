# Annotations

[@ObjectType](docs/Annotations.md#@ObjectType)<br />
[@ObjectField](docs/Annotations.md#@ObjectField)<br />

## @ObjectType

Required attributes:

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

## @ObjectField
