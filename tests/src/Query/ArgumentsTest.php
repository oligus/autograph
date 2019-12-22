<?php declare(strict_types=1);

namespace Tests\Query;

use Autograph\Query\Arguments;
use Tests\TestCase;

class ArgumentsTest extends TestCase
{

    public function testMoo()
    {
        $args =[
            "first" => 2,
            "after" => 5,
            "filter" => [
                "title" => "Test*"
            ]
        ];

        $arguments = new Arguments($args);

        $this->assertEquals(2, $arguments->getFirst());
        $this->assertEquals(5, $arguments->getAfter());
        $this->assertEquals(['title' => "Test*"], $arguments->getFilter());
    }
}
