<?php declare(strict_types=1);

namespace Autograph\Demo\Database\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Autograph\Demo\Database\Repositories\CommonRepository")
 * @ORM\Table(name="genres")
 */
class Genres
{
    /**
     * @ORM\Id
     * @ORM\Column(name="GenreId", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(name="Name", type="string", length=120)
     */
    protected string $name;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
