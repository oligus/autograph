<?php

namespace Autograph\Demo\Database\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Autograph\Demo\Database\Repositories\CommonRepository")
 * @ORM\Table(name="tracks")
 */
class Tracks
{
    /**
     * @ORM\Id
     * @ORM\Column(name="TrackId", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="Name", type="string", length=200)
     */
    protected string $name;

    /**
     * @ORM\OneToOne(targetEntity="Albums")
     * @ORM\JoinColumn(name="AlbumId", referencedColumnName="AlbumId")
     */
    protected Albums $album;

    /**
     * @ORM\OneToOne(targetEntity="MediaTypes")
     * @ORM\JoinColumn(name="MediaTypeId", referencedColumnName="MediaTypeId")
     */
    protected MediaTypes $mediaTypes;

    /**
     * @ORM\OneToOne(targetEntity="Genres")
     * @ORM\JoinColumn(name="GenreId", referencedColumnName="GenreId")
     */
    protected Genres $genre;

    /**
     * @ORM\Column(name="Composer", type="string", length=220)
     */
    protected ?string $composer;

    /**
     * @ORM\Column(name="Milliseconds", type="integer")
     */
    protected int $milliseconds;

    /**
     * @ORM\Column(name="UnitPrice", type="decimal", precision=10, scale=2)
     */
    protected float $price;

    /**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="Playlists")
     * @ORM\JoinTable(name="playlist_track",
     *      joinColumns={@ORM\JoinColumn(name="TrackId", referencedColumnName="TrackId")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="PlaylistId", referencedColumnName="PlaylistId")}
     *      )
     */
    protected Collection $playlists;

    /**
     * Playlists constructor.
     */
    public function __construct()
    {
        $this->playlists =  new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlbum(): Albums
    {
        return $this->album;
    }

    public function getMediaTypes(): MediaTypes
    {
        return $this->mediaTypes;
    }

    public function getGenre(): Genres
    {
        return $this->genre;
    }

    public function getComposer(): ?string
    {
        return $this->composer;
    }

    public function getMilliseconds(): int
    {
        return $this->milliseconds;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

}
