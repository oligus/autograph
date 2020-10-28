<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Autograph\Map\Annotations as AUG;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="albums")
 * @ORM\Entity
 * @AUG\ObjectType(name="album", description="Music album", query={
 *     "fieldName"="albums",
 *     "method"="LIST",
 *     "filter"={"id", "title"}
 * })
 */
class Album
{
    /**
     * @ORM\Column(name="AlbumId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @AUG\ObjectField
     */
    protected int $id;

    /**
     * @ORM\Column(name="Title", type="string", length=160, nullable=false)
     * @AUG\ObjectField
     */
    protected string $title;

    /**
     * @ORM\ManyToOne(targetEntity="Artist", inversedBy="albums")
     * @ORM\JoinColumn(name="ArtistId", referencedColumnName="ArtistId")
     */
    protected Artist $artist;
}
