<?php declare(strict_types=1);

namespace Tests;

use Autograph\Demo\Manager;
use DoctrineFixtures\FixtureManager;
use DoctrineFixtures\Loaders\XmlLoader;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Tools\ToolsException;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\ORM\ORMException;

/**
 * Class Bootstrap
 * @package Tests
 */
class Bootstrap
{
    /**
     * @throws AnnotationException
     * @throws DBALException
     * @throws ORMException
     * @throws ToolsException
     */
    public function run()
    {
        if (!defined('BASE_PATH')) {
            define('BASE_PATH', dirname(__DIR__));
        }

        if (!defined('SRC_PATH')) {
            define('SRC_PATH', BASE_PATH . '/src');
        }

        if (!defined('TEST_PATH')) {
            define('TEST_PATH', BASE_PATH . '/tests');
        }

        ini_set("display_errors", "1");
        error_reporting(E_ALL);

        include __DIR__ . "/../vendor/autoload.php";

        $doctrine = new Doctrine();
        $em = $doctrine->getEm();

        Manager::getInstance()->setEm($em);
    }
}

$bootstrap = new Bootstrap();
$bootstrap->run();
