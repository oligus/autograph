<?php

namespace Demo\Database;

use Demo\Schema\Query\FilterCollection;
use Doctrine\ORM\EntityManager;

/**
 * Class Manager
 * @package Demo\Database
 */
class Manager
{
    /**
     * @var Manager $instance
     */
    private static $instance;

    /**
     * @var EntityManager $em
     */
    private $em;

    /**
     * @var FilterCollection $filterCollection
     */
    private $filterCollection;

    public static function getInstance(): Manager
    {
        if(!self::$instance instanceof Manager) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param EntityManager $em
     */
    public function setEm(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->em;
    }

    /**
     * @return FilterCollection
     */
    public function getFilterCollection(): FilterCollection
    {
        return $this->filterCollection;
    }

    /**
     * @param FilterCollection $filterCollection
     */
    public function setFilterCollection(FilterCollection $filterCollection): void
    {
        $this->filterCollection = $filterCollection;
    }
}