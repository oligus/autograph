<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Territories
 *
 * @ORM\Table(name="Territories", indexes={@ORM\Index(name="IDX_66472C615B7A12F4", columns={"RegionID"})})
 * @ORM\Entity
 */
class Territories
{
    /**
     * @var string
     *
     * @ORM\Column(name="TerritoryID", type="text", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $territoryid;

    /**
     * @var string
     *
     * @ORM\Column(name="TerritoryDescription", type="text", nullable=false)
     */
    private $territorydescription;

    /**
     * @var \Regions
     *
     * @ORM\ManyToOne(targetEntity="Regions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RegionID", referencedColumnName="RegionID")
     * })
     */
    private $regionid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Employees", mappedBy="territoryid")
     */
    private $employeeid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->employeeid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
