<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Suppliers
 *
 * @ORM\Table(name="Suppliers")
 * @ORM\Entity
 */
class Suppliers
{
    /**
     * @var int
     *
     * @ORM\Column(name="SupplierID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $supplierid;

    /**
     * @var string
     *
     * @ORM\Column(name="CompanyName", type="text", nullable=false)
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
     * @var string|null
     *
     * @ORM\Column(name="HomePage", type="text", nullable=true)
     */
    private $homepage;


}
