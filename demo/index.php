<?php declare(strict_types=1);

namespace Autograph\Demo;

use Autograph\Autograph;
use Autograph\Manager;

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$paths = array(realpath(__DIR__ . 'Database/Entities'));

$isDevMode = true;

$connectionParams = array(
    'url' => 'sqlite:///' . 'chinook.db'
);

$config = Setup::createConfiguration($isDevMode);
$driver = new AnnotationDriver(new AnnotationReader(), $paths);

AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);

$em = EntityManager::create($connectionParams, $config);

new Autograph($em);

try {
    echo Request::serve();
} catch (\Exception $e) {
    var_dump($e); die;
}



