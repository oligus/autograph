<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Fields;

use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;
use Exception;

/**
 * Class PlayListsTest
 * @package Autograph\Tests\E2E\Fields
 */
class PlayListsTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @throws Exception
     */
    public function testPlaylists()
    {
        $query = <<<EOL
{
  playLists {
    totalCount
    nodes {
        id
        name
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
  playLists(filter: { name : "%music%" }) {
    totalCount
    nodes {
      id
      name
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
  playLists(first: 2, after: 3) {
    totalCount
    nodes {
      id
      name 
    }
  }
}
EOL;

        $this->assertMatchesJsonSnapshot($this->query($query));
    }
}
