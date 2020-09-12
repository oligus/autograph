<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Regions
 *
 * @ORM\Table(name="Regions")
 * @ORM\Entity
 */
class Regions
{
    /**
     * @var int
     *
     * @ORM\Column(name="RegionID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $regionid;

    /**
     * @var string
     *
     * @ORM\Column(name="RegionDescription", type="text", nullable=false)
     */
    private $regiondescription;


}
