<?php declare(strict_types=1);

namespace Autograph\Demo;

use Autograph\Demo\Schema\AppContext;
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
        $appContext = new AppContext();
        $appContext->rootUrl = 'http://localhost:8888';
        $appContext->request = $_REQUEST;

        // GraphQL schema to be passed to query executor:
        $schema = new Schema([
            'query' => new Query(),
            'mutation' => new Mutation()
        ]);

        $result = GraphQL::executeQuery(
            $schema,
            $this->data['query'],
            null,
            $appContext,
            JsonHelper::toArray($this->data['variables'])
        );

        $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;

        return $result->toArray($debug);
    }
}
