<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shippers
 *
 * @ORM\Table(name="Shippers")
 * @ORM\Entity
 */
class Shippers
{
    /**
     * @var int
     *
     * @ORM\Column(name="ShipperID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $shipperid;

    /**
     * @var string
     *
     * @ORM\Column(name="CompanyName", type="text", nullable=false)
     */
    private $companyname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Phone", type="text", nullable=true)
     */
    private $phone;


}
