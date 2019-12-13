<?php

namespace Autograph\Demo;

use Autograph\Demo\Schema\Query\FilterCollection;
use Doctrine\ORM\EntityManager;

class Manager
{
    private static $instance;

    private EntityManager $em;

    private FilterCollection $filterCollection;

    private function __construct()
    {
        $this->filterCollection = new FilterCollection();
    }

    public static function getInstance(): Manager
    {
        if(!self::$instance instanceof Manager) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setEm(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEm(): EntityManager
    {
        return $this->em;
    }

    public function getFilterCollection(): FilterCollection
    {
        return $this->filterCollection;
    }

    public function setFilterCollection(FilterCollection $filterCollection): void
    {
        $this->filterCollection = $filterCollection;
    }
}
