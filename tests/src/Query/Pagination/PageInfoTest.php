<?php declare(strict_types=1);

namespace Tests\Query\Pagination;

use Autograph\Query\Pagination\PageInfo;
use Tests\TestCase;

class PageInfoTest extends TestCase
{

    public function testMoo()
    {
        $pageInfo = new PageInfo(25);

        echo "Moo";
        die;
    }
}
