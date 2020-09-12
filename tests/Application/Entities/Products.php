<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @ORM\Table(name="Products", indexes={
 *     @ORM\Index(name="IDX_4ACC380CAB3682CB", columns={"SupplierID"})
 * })
 * @ORM\Entity
 */
class Products
{
    /**
     * @var string
     *
     * @ORM\Column(name="ProductName", type="text", nullable=false)
     */
    private $productname;

    /**
     * @var int|null
     *
     * @ORM\Column(name="CategoryID", type="integer", nullable=true)
     */
    private $categoryid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="QuantityPerUnit", type="text", nullable=true)
     */
    private $quantityperunit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="UnitPrice", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $unitprice = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="UnitsInStock", type="integer", nullable=true)
     */
    private $unitsinstock = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="UnitsOnOrder", type="integer", nullable=true)
     */
    private $unitsonorder = '0';

    /**
     * @var int|null
     *
     * @ORM\Column(name="ReorderLevel", type="integer", nullable=true)
     */
    private $reorderlevel = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Discontinued", type="text", nullable=false)
     */
    private $discontinued = '0';

    /**
     * @var \Suppliers
     *
     * @ORM\ManyToOne(targetEntity="Suppliers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SupplierID", referencedColumnName="SupplierID")
     * })
     */
    private $supplierid;

    /**
     * @var \Categories
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ProductID", referencedColumnName="CategoryID")
     * })
     */
    private $productid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Orders", mappedBy="productid")
     */
    private $orderid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
