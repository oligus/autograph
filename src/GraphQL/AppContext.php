<?php declare(strict_types=1);

namespace Autograph\GraphQL;

use Doctrine\ORM\EntityManager;

/**
 * Class AppContext
 * @package Autograph\GraphQL
 */
class AppContext
{
    private EntityManager $em;

    public function getEm(): EntityManager
    {
        return $this->em;
    }

    public function setEm(EntityManager $em): void
    {
        $this->em = $em;
    }
}
