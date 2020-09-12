<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="Orders", indexes={@ORM\Index(name="IDX_E283F8D87250C7E1", columns={"ShipVia"}), @ORM\Index(name="IDX_E283F8D8854CF4BD", columns={"CustomerID"}), @ORM\Index(name="IDX_E283F8D8C9FD356E", columns={"EmployeeID"})})
 * @ORM\Entity
 */
class Orders
{
    /**
     * @var int
     *
     * @ORM\Column(name="OrderID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $orderid;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="OrderDate", type="datetime", nullable=true)
     */
    private $orderdate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="RequiredDate", type="datetime", nullable=true)
     */
    private $requireddate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ShippedDate", type="datetime", nullable=true)
     */
    private $shippeddate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Freight", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $freight = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="ShipName", type="text", nullable=true)
     */
    private $shipname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ShipAddress", type="text", nullable=true)
     */
    private $shipaddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ShipCity", type="text", nullable=true)
     */
    private $shipcity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ShipRegion", type="text", nullable=true)
     */
    private $shipregion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ShipPostalCode", type="text", nullable=true)
     */
    private $shippostalcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ShipCountry", type="text", nullable=true)
     */
    private $shipcountry;

    /**
     * @var \Shippers
     *
     * @ORM\ManyToOne(targetEntity="Shippers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ShipVia", referencedColumnName="ShipperID")
     * })
     */
    private $shipvia;

    /**
     * @var \Customers
     *
     * @ORM\ManyToOne(targetEntity="Customers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CustomerID", referencedColumnName="CustomerID")
     * })
     */
    private $customerid;

    /**
     * @var \Employees
     *
     * @ORM\ManyToOne(targetEntity="Employees")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EmployeeID", referencedColumnName="EmployeeID")
     * })
     */
    private $employeeid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Products", inversedBy="orderid")
     * @ORM\JoinTable(name="order details",
     *   joinColumns={
     *     @ORM\JoinColumn(name="OrderID", referencedColumnName="OrderID")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ProductID", referencedColumnName="ProductID")
     *   }
     * )
     */
    private $productid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
