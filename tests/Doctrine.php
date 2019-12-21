<?php declare(strict_types=1);

namespace Tests;

use Autograph\Demo\Database\Entities\PlaylistTrack;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\SchemaTool;
use DoctrineFixtures\FixtureManager;
use DoctrineFixtures\Loaders\XmlLoader;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Tools\ToolsException;

/**
 * Class Doctrine
 */
class Doctrine
{
    /**
     * @var EntityManager
     */
    private EntityManager $em;

    /**
     * Doctrine constructor.
     * @throws AnnotationException
     * @throws DBALException
     * @throws ORMException
     * @throws ToolsException
     */
    public function __construct()
    {
        $paths      = [BASE_PATH . '/demo/Database/Entities'];
        $proxyPaths = TEST_PATH . '/demo/Database/Proxies';

        $doctrineConfig = new Configuration();

        $driver = new AnnotationDriver(new AnnotationReader(), $paths);
        AnnotationRegistry::registerLoader('class_exists');

        $doctrineConfig->setMetadataDriverImpl($driver);
        $doctrineConfig->setProxyDir($proxyPaths);
        $doctrineConfig->setProxyNamespace('Tests\Proxies');
        $doctrineConfig->setAutoGenerateProxyClasses(true);

        $url = 'sqlite:///:memory:';
        // $url = 'sqlite:///' . TEST_PATH . '/fixtures/moo.db';
        $connectionParams = ['url' => $url];

        $this->em = EntityManager::create($connectionParams, $doctrineConfig);
    }

    public function getEm()
    {
        return $this->em;
    }
}
