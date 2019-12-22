<?php

namespace Autograph;

use Autograph\Query\FilterInputCollection;
use Doctrine\ORM\EntityManager;

class Manager
{
    private static ?self $instance = null;
    private EntityManager $em;
    private FilterInputCollection $filterCollection;

    private function __construct()
    {
        $this->filterCollection = new FilterInputCollection();
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

    public function getFilterCollection(): FilterInputCollection
    {
        return $this->filterCollection;
    }

    public function setFilterCollection(FilterInputCollection $filterCollection): void
    {
        $this->filterCollection = $filterCollection;
    }
}
