<?php declare(strict_types=1);

namespace Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\ToolsException;

/**
 * Class Doctrine
 */
class Doctrine
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Doctrine constructor.
     * @throws AnnotationException
     * @throws ORMException
     * @throws ToolsException
     */
    public function __construct()
    {
        $paths      = [TEST_PATH . '/mock/Entities'];
        $proxyPaths = TEST_PATH . '/mock/Proxies';

        $isDevMode = true;

        $doctrineConfig = new Configuration();

        $driver = new AnnotationDriver(new AnnotationReader(), $paths);
        AnnotationRegistry::registerLoader('class_exists');

        $doctrineConfig->setMetadataDriverImpl($driver);
        $doctrineConfig->setProxyDir($proxyPaths);
        $doctrineConfig->setProxyNamespace('Tests\Proxies');
        $doctrineConfig->setAutoGenerateProxyClasses($isDevMode);

        $database = TEST_PATH . '/fixtures/chinook.db';
        $connectionParams = ['url' => 'sqlite:///' . $database];

        $this->em = EntityManager::create($connectionParams, $doctrineConfig);
    }

    public function getEm()
    {
        return $this->em;
    }
}
