<?php

namespace Autograph\Demo\Database\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Autograph\Demo\Database\Repositories\CommonRepository")
 * @ORM\Table(name="albums")
 */
class Albums
{
    /**
     * @ORM\Id
     * @ORM\Column(name="AlbumId", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(name="Title", type="string", length=160)
     */
    protected string $title;

    /**
     * @ORM\ManyToOne(targetEntity="Artists")
     * @ORM\JoinColumn(name="ArtistId", referencedColumnName="ArtistId")
     */
    protected Artists $artists;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getArtists(): Artists
    {
        return $this->artists;
    }
}
