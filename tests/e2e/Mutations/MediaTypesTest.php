<?php declare(strict_types=1);

namespace Autograph\Tests\E2E\Mutations;

use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;
use Exception;

/**
 * Class MediaTypesTest
 * @package Autograph\Tests\E2E\Mutations
 */
class MediaTypesTest extends TestCase
{

    use MatchesSnapshots;

    /**
     * @throws Exception
     */
    public function testCreate()
    {
        $query = <<< EOF
mutation (\$mediaType: CreateMediaTypeInput!) {
  createMediaType(mediaType: \$mediaType) {
    id
    name
  }
}
EOF;
        $variables = [
            'mediaType' => [
                'name' => 'Test Media Type',
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
mutation (\$mediaType: UpdateMediaTypeInput!) {
  updateMediaType(mediaType: \$mediaType) {
    id
    name
  }
}
EOF;
        $variables = [
            'mediaType' => [
                'id' => '6',
                'name' => 'Test Update Media Type',
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
  deleteMediaType(id: \$id) {
    id
    name
  }
}

EOF;

        $variables = [
            'id' => '6
            '
        ];

        $this->assertMatchesJsonSnapshot($this->query($query, $variables));
    }
}
