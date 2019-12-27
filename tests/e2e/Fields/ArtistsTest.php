<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Fields;

use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;
use Exception;

/**
 * Class ArtistsTest
 * @package Autograph\Tests\E2E\Fields
 */
class ArtistsTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @throws Exception
     */
    public function testArtists()
    {
        $query = <<<EOL
{
  artists {
    totalCount
    nodes {
      id
      name
      albums {
        totalCount
        nodes {
          id
          title
        }     
      }
    }
  }
}
EOL;

        $this->assertMatchesJsonSnapshot($this->query($query));
    }

    public function testFilter()
    {

        $query = <<<EOL
{
  artists(filter: { name : "%ea%" }) {
    totalCount
    nodes {
      id
      name
      albums {
        totalCount
        nodes {
          id
          title
        }     
      }
    }
  }
}
EOL;

        $this->assertMatchesJsonSnapshot($this->query($query));
    }

    public function testPagination()
    {
        $query = <<<EOL
{
  artists(first: 5, after: 5) {
    totalCount
    nodes {
      id
      name
      albums {
        totalCount
        nodes {
          id
          title
        }     
      }
    }
  }
}
EOL;

        $this->assertMatchesJsonSnapshot($this->query($query));
    }
}
