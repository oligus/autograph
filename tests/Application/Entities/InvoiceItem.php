<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="invoice_items")
 * @ORM\Entity
 */
class InvoiceItem
{
    /**
     * @ORM\Column(name="InvoiceLineId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="invoiceItems")
     * @ORM\JoinColumn(name="InvoiceId", referencedColumnName="InvoiceId")
     */
    protected Invoice $invoice;

    /**
     * @ORM\ManyToOne(targetEntity="Track")
     * @ORM\JoinColumn(name="TrackId", referencedColumnName="TrackId")
     */
    protected Track $track;

    /**
     * @ORM\Column(name="UnitPrice", type="decimal", precision=10, scale=2, nullable=false)
     */
    protected float $unitPrice;

    /**
     * @ORM\Column(name="Quantity", type="integer", nullable=false)
     */
    protected int $quantity;
}
