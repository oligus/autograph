<?php declare(strict_types=1);

namespace Demo;

/**
 * Class Request
 * @package Demo
 */
class Request
{
    /**
     * @throws \Exception
     */
    public static function serve()
    {
        if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
            $rawBody     = file_get_contents('php://input');
            $requestData = json_decode($rawBody ?: '', true);
        } else {
            $requestData = $_POST;
        }

        $query = isset($requestData['query']) ? $requestData['query'] : null;
        $variables = isset($requestData['variables']) ? $requestData['variables'] : null;

        $response = new Response([
            'query' => $query,
            'variables' => $variables
        ]);

        return json_encode($response->get());
    }
}