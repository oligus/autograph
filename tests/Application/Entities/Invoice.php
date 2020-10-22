<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="invoices")
 * @ORM\Entity
 */
class Invoice
{
    /**
     * @ORM\Column(name="InvoiceId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(name="CustomerId", referencedColumnName="CustomerId")
     */
    protected Customer $customer;

    /**
     * @ORM\Column(name="InvoiceDate", type="datetime", nullable=false)
     */
    protected DateTime $invoiceDate;

    /**
     * @ORM\OneToMany(targetEntity="InvoiceItem", mappedBy="invoice")
     */
    protected Collection $invoiceItems;

    /**
     * @ORM\Column(name="BillingAddress", type="string", length=70, nullable=true)
     */
    protected ?string $billingAddress;

    /**
     * @ORM\Column(name="BillingCity", type="string", length=40, nullable=true)
     */
    protected ?string $billingCity;

    /**
     * @ORM\Column(name="BillingState", type="string", length=40, nullable=true)
     */
    protected ?string $billingState;

    /**
     * @ORM\Column(name="BillingCountry", type="string", length=40, nullable=true)
     */
    protected ?string $billingCountry;

    /**
     * @ORM\Column(name="BillingPostalCode", type="string", length=10, nullable=true)
     */
    protected ?string $billingPostalCode;

    /**
     * @ORM\Column(name="Total", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected string $total;
}
