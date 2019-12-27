<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Fields;

use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;
use Exception;

/**
 * Class AlbumsTest
 * @package Autograph\Tests\E2E\Fields
 */
class AlbumsTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @throws Exception
     */
    public function testAlbums()
    {
        $query = <<<EOL
{
  albums(first: 10) {
    totalCount
    count
    nodes {
      id
      title
      artist {
        id
        name
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
  albums(filter: {title: "ball"}) {
    totalCount
    count
    nodes {
      id
      title
      artist {
        id
        name
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
  albums(first: 5, after: 5) {
    totalCount
    count
    nodes {
      id
      title
      artist {
        id
        name
      }
    }
  }
}
EOL;

        $this->assertMatchesJsonSnapshot($this->query($query));
    }
}
