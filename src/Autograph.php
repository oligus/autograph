<?php declare(strict_types=1);

namespace Autograph;

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Error\Debug;
use Doctrine\ORM\EntityManagerInterface;

use Autograph\Helpers\JsonHelper;
use Autograph\Demo\Schema\AppContext;
use Autograph\Demo\Schema\Types\QueryType;
use Autograph\Demo\Schema\Types\MutationType;

/**
 * Class Autograph
 * @package Autograph
 */
class Autograph
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $variables;

    /**
     * Autograph constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $query
     */
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    /**
     * @param string $variables
     */
    public function setVariables(string $variables): void
    {
        $this->variables = $variables;
    }

    /**
     * @return mixed[]
     * @throws \Exception
     */
    public function render()
    {
        $appContext = new AppContext();
        $appContext->rootUrl = 'http://localhost:8080';
        $appContext->request = $_REQUEST;

        // GraphQL schema to be passed to query executor:
        $schema = new Schema([
            'query' => new QueryType(),
            'mutation' => new MutationType()
        ]);

        $result = GraphQL::executeQuery(
            $schema,
            $this->query,
            null,
            $appContext,
            JsonHelper::toArray($this->variables)
        );

        $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;

        return json_encode($result->toArray($debug), JSON_PRETTY_PRINT);
    }
}
