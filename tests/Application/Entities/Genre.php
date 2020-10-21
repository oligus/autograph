<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="genres")
 * @ORM\Entity
 */
class Genre
{
    /**
     * @ORM\Column(name="GenreId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected int $id;

    /**
     * @ORM\Column(name="Name", type="string", length=120, nullable=true)
     */
    protected ?string $name;
}
