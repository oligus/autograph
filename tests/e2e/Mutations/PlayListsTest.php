<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Mutations;

use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;
use Exception;

/**
 * Class PlayListsTest
 * @package Autograph\Tests\E2E\Mutations
 */
class PlayListsTest extends TestCase
{

    use MatchesSnapshots;

    /**
     * @throws Exception
     */
    public function testCreate()
    {
        $query = <<< EOF
mutation (\$playList: CreatePlayListInput!) {
  createPlayList(playList: \$playList) {
    id
    name
  }
}
EOF;
        $variables = [
            'playList' => [
                'name' => 'Test PlayList',
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
mutation (\$playList: UpdatePlayListInput!) {
  updatePlayList(playList: \$playList) {
    id
    name
  }
}
EOF;
        $variables = [
            'playList' => [
                'id' => '19',
                'name' => 'Test Update PlayList',
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
  deletePlayList(id: \$id) {
    id
    name
  }
}

EOF;

        $variables = [
            'id' => '19'
        ];

        $this->assertMatchesJsonSnapshot($this->query($query, $variables));
    }
}
