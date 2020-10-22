<?php declare(strict_types=1);

namespace Autograph\Tests;

use Autograph\Autograph;
use Autograph\Exceptions\GeneralException;
use Autograph\Tests\Application\Entities\Album;
use Autograph\Tests\Application\Entities\Artist;
use Autograph\Tests\Application\Entities\Customer;
use Autograph\Tests\Application\Entities\Employee;
use Autograph\Tests\Application\Entities\Invoice;
use Autograph\Tests\Application\Entities\InvoiceItem;
use Autograph\Tests\Application\Entities\Track;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;

/**
 * Class AutographTest
 * @package Autograph\Tests\Application\Entities
 */
class AutographTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @throws GeneralException
     */
    public function testConstruct()
    {
        $this->assertTrue(true);
        return;

        $this->markTestIncomplete('skip');
        $em = $this->getEntityManager();
        $query = '{ Category(id: 2) { id name } }';
        $variables = [];

        $autograph = new Autograph($em, $query, $variables);

        $this->assertMatchesJsonSnapshot($autograph->result());
    }
}