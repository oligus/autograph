<?php declare(strict_types=1);

namespace Autograph\Tests\E2E;

use Autograph\GraphQL\TypeManager;
use Autograph\GraphQL\Types\Query;
use Autograph\Map\AnnotationMapper;
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
     * @throws \Doctrine\Persistence\Mapping\MappingException
     */
    public function testSchema()
    {
        $em = $this->getEntityManager();
        $em->clear();
        TypeManager::clear();
        $mapper = new AnnotationMapper($this->getEntityManager());
        $query = Query::create($mapper);
        $schema = new Schema([
            'query' => $query
        ]);

        $this->assertMatchesSnapshot(SchemaPrinter::doPrint($schema));
    }
}
