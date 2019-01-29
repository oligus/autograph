<?php

namespace Demo;

require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Demo\Database\Manager;
use Demo\Request;
use Demo\Helpers\ErrorHelper;
use Demo\Schema\Query\FilterCollection;

$paths = array(realpath(__DIR__ . 'Database/Entities'));

$isDevMode = true;

$connectionParams = array(
    'url' => 'sqlite:///' . 'blog.db'
);

$config = Setup::createConfiguration($isDevMode);
$driver = new AnnotationDriver(new AnnotationReader(), $paths);

AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);

$em = EntityManager::create($connectionParams, $config);

$manager = Manager::getInstance();
$manager = Manager::getInstance();
$manager->setEm($em);
$manager->setFilterCollection(new FilterCollection());

try {
    echo Request::serve();
} catch (\Exception $e) {
    var_dump($e); die;
    ErrorHelper::simple($e);
}



