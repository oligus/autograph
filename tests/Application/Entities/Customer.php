<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="customers")
 * @ORM\Entity
 */
class Customer
{
    /**
     * @ORM\Column(name="CustomerId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected int $id;

    /**
     * @ORM\Column(name="FirstName", type="string", length=40, nullable=false)
     */
    protected string $firstName;

    /**
     * @ORM\Column(name="LastName", type="string", length=20, nullable=false)
     */
    protected string $lastName;

    /**
     * @ORM\Column(name="Company", type="string", length=80, nullable=true)
     */
    protected ?string $company;

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
     * @ORM\Column(name="Email", type="string", length=60, nullable=false)
     */
    protected string $email;

    /**
     * @ORM\Column(name="SupportRepId", type="integer", nullable=true)
     */
    protected ?string $supportrepid;
}
