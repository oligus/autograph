<?php

namespace Autograph\Demo\Database\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="invoice_items")
 */
class InvoiceItems
{
    /**
     * @ORM\Id
     * @ORM\Column(name="InvoiceLineId", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="InvoiceId", type="integer", length=120)
     */
    protected $invoiceId;

    /**
     * @ORM\Column(name="TrackId", type="integer", length=120)
     */
    protected $trackId;

    /**
     * @ORM\Column(name="UnitPrice", type="decimal", precision=10, scale=2)
     */
    protected $unitPrice;

    /**
     * @ORM\Column(name="Quantity", type="integer", length=120)
     */
    protected $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Invoices")
     * @ORM\JoinColumn(name="InvoiceId", referencedColumnName="InvoiceId")
     */
    protected $invoices;
}
