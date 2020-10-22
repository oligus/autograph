<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Fields;

use Autograph\Autograph;
use Doctrine\ORM\Mapping\MappingException;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;

/**
 * Class TrackTest
 * @package Autograph\Tests\E2E\Fields
 */
class TrackTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @throws MappingException
     */
    public function testQuery()
    {
        $query = <<< EOF
{
  tracks(id: 1) {
    id
    name
    composer
    milliseconds
    bytes
    unitPrice
  }
}
EOF;

        $variables = [];
        $autograph = new Autograph($this->getEntityManager(), $query, $variables);

        $this->assertMatchesJsonSnapshot($autograph->result());
    }
}
