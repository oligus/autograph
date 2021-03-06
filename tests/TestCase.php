<?php declare(strict_types=1);

namespace Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class TestCase
 * @package Tests
 */
abstract class TestCase extends PHPUnitTestCase
{
    /**
     * @var EntityManager|null
     */
    private ?EntityManager $em = null;

    public function getEntityManager(): EntityManager
    {
        if ($this->em instanceof EntityManager) {
            return $this->em;
        }

        $isDevMode = true;

        $config = Setup::createConfiguration($isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), [TEST_PATH . '/Application/Entities']);
        $config->setMetadataDriverImpl($driver);

        $conn = [
            'driver' => 'pdo_sqlite',
            'path' => TEST_PATH . '/database/chinook.db',
        ];

        $this->em = EntityManager::create($conn, $config);


        return $this->em;
    }

    /**
     * @param $className
     * @param $methodName
     * @return ReflectionMethod
     * @throws ReflectionException
     */
    protected static function getMethod($className, $methodName)
    {
        $class = new ReflectionClass($className);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }

    /**
     * @param $className
     * @param $property
     * @param $value
     * @throws ReflectionException
     */
    public function setProtectedProperty($className, $property, $value)
    {
        $reflection = new ReflectionClass($className);
        $reflection_property = $reflection->getProperty($property);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($className, $value);
    }

    /**
     * @param $className
     * @param array $options
     * @return MockObject
     */
    protected function getClassMock($className, array $options = array())
    {
        $mock = $this->getMockBuilder($className)
            ->setMethods(array_keys($options))
            ->getMock();

        foreach ($options as $method => $value) {
            $mock->expects($this->any())
                ->method($method)
                ->will($this->returnValue($value));
        }

        return $mock;
    }

}
