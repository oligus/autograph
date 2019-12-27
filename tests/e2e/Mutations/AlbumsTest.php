<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Mutations;

use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;
use Exception;

/**
 * Class AlbumsTest
 * @package Autograph\Tests\E2E\Mutations
 */
class AlbumsTest extends TestCase
{

    use MatchesSnapshots;

    /**
     * @throws Exception
     */
    public function testCreate()
    {
        $query = <<< EOF
mutation (\$album: CreateAlbumInput!) {
  createAlbum(album: \$album) {
    id
    title
    artist {
      id
      name
    }
  }
}
EOF;
        $variables = [
            'album' => [
                'title' => 'Test Album',
                'artist' => 100
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
mutation (\$album: UpdateAlbumInput!) {
  updateAlbum(album: \$album) {
    id
    title
  }
}
EOF;
        $variables = [
            'album' => [
                'id' => '348',
                'title' => 'Test Update Album',
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
  deleteAlbum(id: \$id) {
    id
    title
  }
}

EOF;

        $variables = ['id' => '348'];
        $this->assertMatchesJsonSnapshot($this->query($query, $variables));
    }
}
