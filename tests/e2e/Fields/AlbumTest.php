<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Fields;

use Autograph\Autograph;
use Doctrine\ORM\Mapping\MappingException;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;

/**
 * Class SupplierTest
 * @package Autograph\Tests\E2E\Fields
 */
class AlbumTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @throws MappingException
     */
    public function testQuery()
    {
        $query = <<< EOF
{
  albums(filter: { id: 1 }) {
    totalCount
    nodes {
      id
      title
    }
  }
}
EOF;

        $variables = [];
        $autograph = new Autograph($this->getEntityManager(), $query, $variables);

        $this->assertMatchesJsonSnapshot($autograph->result());
    }

    /**
     * @throws MappingException
     */
    public function testPagination()
    {
        $query = <<< EOF
{
  albums(first: 5, after: 10) {
    totalCount
    nodes {
      id
      title
    }
  }
}
EOF;

        $variables = [];
        $autograph = new Autograph($this->getEntityManager(), $query, $variables);

        $this->assertMatchesJsonSnapshot($autograph->result());
    }
}
