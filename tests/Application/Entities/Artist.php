<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="artists")
 * @ORM\Entity
 */
class Artist
{
    /**
     * @ORM\Column(name="ArtistId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected int $id;

    /**
     * @ORM\Column(name="Name", type="string", length=120, nullable=true)
     */
    protected string $name;

    /**
     * @ORM\OneToMany(targetEntity="Album", mappedBy="artist")
     */
    protected Collection $albums;
}
