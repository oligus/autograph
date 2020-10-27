<?php declare(strict_types=1);

namespace Autograph\Tests\Application;

use Autograph\GraphQL\AppContext;
use Autograph\Tests\Application\Schema\Types\Query;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use GraphQL\Error\DebugFlag;
use GraphQL\Server\StandardServer;
use GraphQL\Type\Schema;

include __DIR__ . "/../../vendor/autoload.php";

$appContext = new AppContext();

$config = Setup::createConfiguration(true);
$driver = new AnnotationDriver(new AnnotationReader(), [__DIR__. '/Entities']);
$config->setMetadataDriverImpl($driver);

$conn = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../database/chinook.db'
];

$appContext->setEm(EntityManager::create($conn, $config));

$schema = new Schema([
    'query' => new Query(),
    //'mutation' => new Mutation()
]);

$server = new StandardServer([
    'schema' => $schema,
    'context' => $appContext,
    'rootValue' => null,
    'debugFlag' => DebugFlag::INCLUDE_DEBUG_MESSAGE|DebugFlag::INCLUDE_TRACE
]);

$_POST['variables'] = $_POST['variables'] === 'undefined' ? null : $_POST['variables'];
$server->handleRequest(); // parses PHP globals and emits response
