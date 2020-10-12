<?php declare(strict_types=1);

namespace Autograph\Tests\E2E;

use Autograph\Map\AnnotationMapper;
use Autograph\Map\QueryFactory;
use Doctrine\ORM\Mapping\MappingException;
use GraphQL\Type\Schema;
use GraphQL\Utils\SchemaPrinter;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;

class SchemaTest extends TestCase
{
    use MatchesSnapshots;

    /**
     * @throws MappingException
     */
    public function testSchema()
    {
        $em = $this->getEntityManager();
        $em->clear();
        $mapper = new AnnotationMapper($this->getEntityManager());
        $query = QueryFactory::create($mapper);
        $schema = new Schema([
            'query' => $query
        ]);

        $this->assertMatchesSnapshot(SchemaPrinter::doPrint($schema));
    }
}
