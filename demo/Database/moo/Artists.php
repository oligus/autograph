<?php

namespace Autograph\Demo\Database\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Autograph\Demo\Database\Repositories\CommonRepository")
 * @ORM\Table(name="artists")
 */
class Artists
{
    /**
     * @ORM\Id
     * @ORM\Column(name="ArtistId", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="Name", type="string", length=120)
     */
    protected string $name;

    /**
     * @ORM\OneToMany(targetEntity="Albums", mappedBy="artists")
     */
    protected Collection $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlbums(): Collection
    {
        return $this->albums;
    }
}
