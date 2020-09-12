<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employees
 *
 * @ORM\Table(name="Employees")
 * @ORM\Entity
 */
class Employees
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="LastName", type="text", nullable=true)
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="FirstName", type="text", nullable=true)
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Title", type="text", nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TitleOfCourtesy", type="text", nullable=true)
     */
    private $titleofcourtesy;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="BirthDate", type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="HireDate", type="date", nullable=true)
     */
    private $hiredate;

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
     * @ORM\Column(name="HomePhone", type="text", nullable=true)
     */
    private $homephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Extension", type="text", nullable=true)
     */
    private $extension;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Photo", type="blob", nullable=true)
     */
    private $photo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ReportsTo", type="integer", nullable=true)
     */
    private $reportsto;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PhotoPath", type="text", nullable=true)
     */
    private $photopath;

    /**
     * @var \Employees
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Employees")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EmployeeID", referencedColumnName="EmployeeID")
     * })
     */
    private $employeeid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Territories", inversedBy="employeeid")
     * @ORM\JoinTable(name="employeeterritories",
     *   joinColumns={
     *     @ORM\JoinColumn(name="EmployeeID", referencedColumnName="EmployeeID")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="TerritoryID", referencedColumnName="TerritoryID")
     *   }
     * )
     */
    private $territoryid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->territoryid = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
