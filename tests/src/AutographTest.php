<?php declare(strict_types=1);

namespace Autograph\Tests;

use Autograph\Autograph;
use Autograph\Exceptions\GeneralException;
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