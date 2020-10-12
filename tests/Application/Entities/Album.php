<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;
use Autograph\Map\Annotations as AUG;

/**
 * Album
 *
 * @ORM\Table(name="albums")
 * @ORM\Entity
 * @AUG\ObjectType(name="album", description="Music album", queryField="albums", queryType="list")
 */
class Album
{
    /**
     * @ORM\Column(name="AlbumId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @AUG\ObjectField(filterable=true)
     */
    protected int $id;

    /**
     * @ORM\Column(name="Title", type="string", length=160, nullable=false)
     * @AUG\ObjectField(filterable=true)
     */
    protected string $title;

    /**
     * @ORM\Column(name="ArtistId", type="integer", nullable=false)
     */
    protected string $artistId;
}
