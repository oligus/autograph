<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Fields;

use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;
use Exception;

/**
 * Class MediaTypesTest
 * @package Autograph\Tests\E2E\Fields
 */
class MediaTypesTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @throws Exception
     */
    public function testMediaTypes()
    {
        $query = <<<EOL
{
  mediaTypes {
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
  mediaTypes(filter: { name : "%MPEG%" }) {
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
  mediaTypes(first: 2, after: 3) {
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
