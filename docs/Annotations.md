# Autograph

[<< Back](../README.md)

## Annotations

[@ObjectType](Annotations.md#objecttype)<br />
[@ObjectField](Annotations.md#objectfield)<br />

## @ObjectType

Optional attributes:
* **name** Name of the GraphQL object type, if omitted will be set to current class name
* **description** GraphQL object type description.
* **query** GraphQL root query field
  * **fieldName**
  * **method** Field return method, one of the following   
    * **single**  Return a single object by ID
    * **list**    Return a List of objects, filterable
  * **filter** List of filterable fields

Example:

```php
use Autograph\Map\Annotations as AUG;

/**
 * @ORM\Entity
 * @ORM\Table(name="albums")
 * @AUG\ObjectType(name="album", description="Music album", query={
 *     "fieldName"="albums",
 *     "method"="LIST",
 *     "filter"={"id", "title"}
 * })
 */
class Album
...
```

Rendered GraphQL:
```graphql
type Albums {
  totalCount: Int
  nodes: [album]
}

"""Stimplify Query fields"""
type Query {
  albums(first: Int, after: Int = 0, filter: albumFilter): Albums
}

type album {
  id: ID!
  title: String!
}

input albumFilter {
  id: ID
  title: String
}



"""Music album"""
type album {
  ...
}

input albumFilter {
  ...
}

type Query {
  albums(first: Int, after: Int = 0, filter: albumFilter): [album]
  ...
}
```

## @ObjectField

Optional attributes:
* **name** Name of the GraphQL field, if omitted will be set to property name
* **description** GraphQL field description.
* **type** GraphQL type, eg `String`, `Int!`
* **filterable** Boolean, if object type is a list, you can filter on this property

Examples:

```php
use Autograph\Map\Annotations as AUG;
...

/**
  * @ORM\Column(name="CategoryName", type="text", nullable=false)
  * @AUG\ObjectField(name="name", type="String!", description="Name of category", filterable=true)
  */
protected string $name;
```



