<?php declare(strict_types=1);

namespace Autograph;

use Autograph\GraphQL\AppContext;
use Autograph\Map\AnnotationMapper;
use Autograph\Map\QueryFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\MappingException;
use GraphQL\Error\DebugFlag;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;

/**
 * Class Autograph
 * @package Autograph
 */
class Autograph
{
    private EntityManager $em;

    private string $query;

    /**
     * @var array<mixed>
     */
    private array $variables;

    /**
     * @param array<mixed> $variables
     */
    public function __construct(EntityManager $em, string $query, array $variables)
    {
        $this->em = $em;
        $this->query = $query;
        $this->variables = $variables;
    }

    /**
     * @throws MappingException
     */
    public function result(): ?string
    {
        $mapper = new AnnotationMapper($this->em);

        // Create Query object
        $query = QueryFactory::create($mapper);

        $appContext = new AppContext();
        $appContext->setEm($this->em);

        $schema = new Schema([
            'query' => $query
        ]);

        $result = GraphQL::executeQuery(
            $schema,
            $this->query,
            null,
            $appContext,
            $this->variables
        );

        $returnString = json_encode($result->toArray(DebugFlag::INCLUDE_TRACE));

        if (is_bool($returnString)) {
            return null;
        }

        return $returnString;
    }
}
