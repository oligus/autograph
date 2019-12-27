<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Mutations;

use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;
use Exception;

/**
 * Class ArtistsTest
 * @package Autograph\Tests\E2E\Mutations
 */
class ArtistsTest extends TestCase
{

    use MatchesSnapshots;

    /**
     * @throws Exception
     */
    public function testCreate()
    {
        $query = <<< EOF
mutation (\$artist: CreateArtistInput!) {
  createArtist(artist: \$artist) {
    id
    name
  }
}
EOF;
        $variables = [
            'artist' => [
                'name' => 'Test Artist',
            ]
        ];

        $this->assertMatchesJsonSnapshot($this->query($query, $variables));
    }

    /**
     * @depends testCreate
     * @throws Exception
     */
    public function testUpdate()
    {
        $query = <<< EOF
mutation (\$artist: UpdateArtistInput!) {
  updateArtist(artist: \$artist) {
    id
    name
  }
}
EOF;
        $variables = [
            'artist' => [
                'id' => '276',
                'name' => 'Test Update Artist',
            ]
        ];

        $this->assertMatchesJsonSnapshot($this->query($query, $variables));
    }

    /**
     * @depends testUpdate
     * @throws Exception
     */
    public function testDelete()
    {
        $query = <<< EOF
mutation (\$id: ID!) {
  deleteArtist(id: \$id) {
    id
    name
  }
}

EOF;

        $variables = ['id' => '276'];
        $this->assertMatchesJsonSnapshot($this->query($query, $variables));
    }
}
