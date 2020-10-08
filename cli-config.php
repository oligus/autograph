<?php declare(strict_types=1);

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;

if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__);
}

if (!defined('SRC_PATH')) {
    define('SRC_PATH', BASE_PATH . '/src');
}

if (!defined('TEST_PATH')) {
    define('TEST_PATH', BASE_PATH . '/tests');
}

ini_set("display_errors", "1");
error_reporting(E_ALL);

set_include_path(BASE_PATH . PATH_SEPARATOR . get_include_path());

include __DIR__ . "/vendor/autoload.php";

$isDevMode = true;
$proxyDir = null;
$cache = null;

$config = Setup::createConfiguration($isDevMode);
$driver = new AnnotationDriver(new AnnotationReader(), [TEST_PATH . '/Application/Entities']);
$config->setMetadataDriverImpl($driver);

$conn = [
    'driver' => 'pdo_sqlite',
    'path' => TEST_PATH . '/database/chinook.db',
];

$entityManager = EntityManager::create($conn, $config);

return ConsoleRunner::createHelperSet($entityManager);
