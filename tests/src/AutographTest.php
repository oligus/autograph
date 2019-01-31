<?php declare(strict_types=1);

namespace Autograph\Tests;

use Autograph\Demo\Database\Manager;
use Tests\TestCase;
use Autograph\Autograph;
use Spatie\Snapshots\MatchesSnapshots;

/**
 * Class AutographTest
 * @package Autograph\Tests
 */
class AutographTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @throws \Exception
     */
    public function testCreate()
    {
        $em = Manager::getInstance()->getEm();

        $autograph = new Autograph($em);
        $autograph->setQuery(<<<EOL
{
  author(id: 1) {
    id
    name
  }
}
EOL
);
        $result = $autograph->render();
        $this->assertMatchesJsonSnapshot( $autograph->render());
    }
}
