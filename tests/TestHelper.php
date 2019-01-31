<?php declare(strict_types=1);

namespace Tests;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Autograph\Demo\Database\Manager;
use Autograph\Demo\Schema\Query\FilterCollection;

/**
 * Class TestHelper
 * @package Tests
 */
class TestHelper
{

    /**
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \Doctrine\ORM\ORMException
     */
    public function run()
    {
        $paths = array(realpath(__DIR__ . '/../demo/Database/Entities'));

        $isDevMode = true;

        $connectionParams = array(
            'url' => 'sqlite:///' . realpath(__DIR__ . '/../demo/blog.db')
        );

        $config = Setup::createConfiguration($isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), $paths);

        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);

        $em = EntityManager::create($connectionParams, $config);

        $manager = Manager::getInstance();
        $manager->setEm($em);
        $manager->setFilterCollection(new FilterCollection());
    }
}

$helper = new TestHelper();
$helper->run();