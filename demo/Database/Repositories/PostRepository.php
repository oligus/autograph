<?php

namespace Autograph\Demo\Database\Repositories;

use Doctrine\ORM\Query\ResultSetMapping;

class PostRepository extends CommonRepository
{
    public function findPostsBetweenDates(\DateTime $fromDate, \DateTime $toDate)
    {
        /* @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getEntityManager();

        $rsm = new ResultSetMapping();

        $sql = 'SELECT * FROM posts WHERE postDate BETWEEN ? AND ?';
        $query = $em->createNativeQuery($sql, $rsm);

        $query->setParameter(1, $fromDate->format('Y-m-d'));
        $query->setParameter(2, $toDate->format('Y-m-d'));




    }
}
