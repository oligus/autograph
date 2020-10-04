<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;
use Autograph\Map\Annotations as AUG;

/**
 * Categories
 *
 * @ORM\Entity
 * @ORM\Table(name="Categories")
 * @AUG\ObjectType(name="Category", description="A category")
 */
class Categories
{
    /**
     * @ORM\Column(name="CategoryID", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @AUG\ObjectField
     */
    protected int $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CategoryName", type="text", nullable=true)
     * @AUG\ObjectField(name="name", type="String", description="Name of category")
     */
    protected ?string $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Description", type="text", nullable=true)
     * @AUG\ObjectField
     */
    protected ?string $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Picture", type="blob", nullable=true)
     * @AUG\ObjectField
     */
    protected $picture;
}
