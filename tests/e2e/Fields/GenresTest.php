<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Fields;

use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;
use Exception;

/**
 * Class Genres
 * @package Autograph\Tests\E2E
 */
class GenresTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @throws Exception
     */
    public function testGenres()
    {
        $query = <<<EOL
{
  genres {
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
  genres(filter: { name : "%ea%" }) {
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
  genres(first: 5, after: 5) {
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
