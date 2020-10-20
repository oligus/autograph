<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;
use Autograph\Map\Annotations as AUG;

/**
 * Album
 *
 * @ORM\Table(name="tracks")
 * @ORM\Entity
 * @AUG\ObjectType(query={
 *     "fieldName"="tracks",
 *     "method"="SINGLE"
 * })
 */
class Track
{
    /**
     * @ORM\Column(name="TrackId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @AUG\ObjectField
     */
    protected int $id;

    /**
     * @ORM\Column(name="Name", type="string", length=200)
     * @AUG\ObjectField
     */
    protected string $name;

    /**
     * @ORM\Column(name="AlbumId", type="integer")
     * @AUG\ObjectField
     */
    protected string $albumId;

    /**
     * @ORM\Column(name="MediaTypeId", type="integer")
     * @AUG\ObjectField
     */
    protected string $mediaTypeId;

    /**
     * @ORM\Column(name="GenreId", type="integer")
     * @AUG\ObjectField
     */
    protected string $genreId;

    /**
     * @ORM\Column(name="Composer", type="string", length=220)
     * @AUG\ObjectField
     */
    protected string $composer;

    /**
     * @ORM\Column(name="Milliseconds", type="integer")
     * @AUG\ObjectField
     */
    protected string $milliseconds;

    /**
     * @ORM\Column(name="Bytes", type="integer")
     * @AUG\ObjectField
     */
    protected string $bytes;

    /**
     * @ORM\Column(name="UnitPrice", type="decimal", precision=10, scale=2)
     * @AUG\ObjectField
     */
    protected string $unitPrice;
}
