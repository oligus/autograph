<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="employees")
 * @ORM\Entity
 */
class Employee
{
    /**
     * @ORM\Column(name="EmployeeId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected int $id;

    /**
     * @ORM\Column(name="LastName", type="string", length=20, nullable=false)
     */
    protected string $lastName;

    /**
     * @ORM\Column(name="FirstName", type="string", length=20, nullable=false)
     */
    protected string $firstName;

    /**
     * @ORM\Column(name="Title", type="string", length=30, nullable=true)
     */
    protected ?string $title;

    /**
     * @ORM\Column(name="ReportsTo", type="integer", nullable=true)
     */
    protected ?int $reportsTo;

    /**
     * @ORM\Column(name="BirthDate", type="datetime", nullable=true)
     */
    protected ?DateTime $birthDate;

    /**
     * @ORM\Column(name="HireDate", type="datetime", nullable=true)
     */
    protected ?DateTime $hireDate;

    /**
     * @ORM\Column(name="Address", type="string", length=70, nullable=true)
     */
    protected ?string $address;

    /**
     * @ORM\Column(name="City", type="string", length=40, nullable=true)
     */
    protected ?string $city;

    /**
     * @ORM\Column(name="State", type="string", length=40, nullable=true)
     */
    protected ?string $state;

    /**
     * @ORM\Column(name="Country", type="string", length=40, nullable=true)
     */
    protected ?string $country;

    /**
     * @ORM\Column(name="PostalCode", type="string", length=10, nullable=true)
     */
    protected ?string $postalCode;

    /**
     * @ORM\Column(name="Phone", type="string", length=24, nullable=true)
     */
    protected ?string $phone;

    /**
     * @ORM\Column(name="Fax", type="string", length=24, nullable=true)
     */
    protected ?string $fax;

    /**
     * @ORM\Column(name="Email", type="string", length=60, nullable=true)
     */
    protected ?string $email;
}
