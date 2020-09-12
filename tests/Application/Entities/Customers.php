<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customers
 *
 * @ORM\Table(name="Customers")
 * @ORM\Entity
 */
class Customers
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="CustomerID", type="text", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $customerid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="CompanyName", type="text", nullable=true)
     */
    private $companyname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ContactName", type="text", nullable=true)
     */
    private $contactname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ContactTitle", type="text", nullable=true)
     */
    private $contacttitle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Address", type="text", nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="City", type="text", nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Region", type="text", nullable=true)
     */
    private $region;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PostalCode", type="text", nullable=true)
     */
    private $postalcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Country", type="text", nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Phone", type="text", nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Fax", type="text", nullable=true)
     */
    private $fax;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Customerdemographics", inversedBy="customerid")
     * @ORM\JoinTable(name="customercustomerdemo",
     *   joinColumns={
     *     @ORM\JoinColumn(name="CustomerID", referencedColumnName="CustomerID")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="CustomerTypeID", referencedColumnName="CustomerTypeID")
     *   }
     * )
     */
    private $customertypeid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->customertypeid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
