<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customerdemographics
 *
 * @ORM\Table(name="CustomerDemographics")
 * @ORM\Entity
 */
class Customerdemographics
{
    /**
     * @var string
     *
     * @ORM\Column(name="CustomerTypeID", type="text", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $customertypeid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CustomerDesc", type="text", nullable=true)
     */
    private $customerdesc;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Customers", mappedBy="customertypeid")
     */
    private $customerid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->customerid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
