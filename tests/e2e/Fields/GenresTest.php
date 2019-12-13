<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Fields;

use Autograph\Demo\Response;
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
    public function testGenre()
    {
        $query = <<<EOL
{
  genre(id: 1) {
    id
    name
  }
}
EOL;

        $response = new Response([
            'query' => $query,
            'variables' => []
        ]);

        $this->assertMatchesJsonSnapshot($this->query($query));
    }

    /**
     * @throws Exception
     */
    public function testGenres()
    {
        $query = <<<EOL
{
  genres {
    count
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
