<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Mutations;

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
    public function testCreate()
    {
        $query = <<< EOF
mutation (\$genre: CreateGenreInput!) {
  createGenre(genre: \$genre) {
    id
    name
  }
}
EOF;
        $variables = [
            'genre' => [
                'name' => 'Test Genre',
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
mutation (\$genre: UpdateGenreInput!) {
  updateGenre(genre: \$genre) {
    id
    name
  }
}
EOF;
        $variables = [
            'genre' => [
                'id' => '26',
                'name' => 'Test Update Genre',
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
  deleteGenre(id: \$id) {
    id
    name
  }
}

EOF;

        $variables = [
            'id' => '26
            '
        ];

        $this->assertMatchesJsonSnapshot($this->query($query, $variables));
    }
}
