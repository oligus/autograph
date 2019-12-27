<?php declare(strict_types=1);

namespace Autograph\Demo;

use Autograph\Context;
use Autograph\Demo\Schema\Types\Mutation;
use Autograph\Demo\Schema\Types\Query;
use Autograph\Demo\Helpers\JsonHelper;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Error\Debug;
use Exception;

/**
 * Class Response
 * @package Server
 */
class Response
{
    /**
     * @var array $data
     */
    private array $data;

    /**
     * Response constructor.
     * @param $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function get()
    {
        $context = new Context();
        $context->rootUrl = 'http://localhost:8888';
        $context->request = $_REQUEST;

        // GraphQL schema to be passed to query executor:
        $schema = new Schema([
            'query' => new Query(),
            'mutation' => new Mutation()
        ]);

        $result = GraphQL::executeQuery(
            $schema,
            $this->data['query'],
            null,
            $context,
            JsonHelper::toArray($this->data['variables'])
        );

        $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;

        return $result->toArray($debug);
    }
}
