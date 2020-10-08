# Annotations

[@ObjectType](Annotations.md#objecttype)<br />
[@ObjectField](Annotations.md#objectfield)<br />

## @ObjectType

Optional attributes:
* **name** Name of the GraphQL object type, if omitted will be set to current class name
* **description** GraphQL object type description.
* **queryField** GraphQL root query name
* **queryType** GraphQL root query type, one of the following
  * **none**    No root query    
  * **single**  Single record query
  * **list**    List of objects

Example:

```php
use Autograph\Map\Annotations as AUG;

/**
 * @ORM\Entity
 * @ORM\Table(name="albums")
 * @AUG\ObjectType(name="album", description="Music album", queryField="albums", queryType="list")
 */
class Album
...
```

Rendered GraphQL:
```graphql
"""Music album"""
type album {
  ...
}

type Query {
  albums: [album]
  ...
}
```

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



