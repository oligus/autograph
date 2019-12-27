<?php declare(strict_types=1);

namespace Autograph\Demo\Database\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CommonRepository
 * @package Autograph\Demo\Database\Repositories
 */
class CommonRepository extends EntityRepository
{
    /**
     * @param array<string,mixed> $args
     * @return mixed
     */
    public function filter(array $args)
    {
        /* @var EntityManager $em */
        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder()
            ->select('t')
            ->from($this->_entityName, 't');

        $filter = $args['filter'] ?? [];
        foreach ($filter as $field => $value) {
            if($field === 'id') {
                $qb->andWhere($qb->expr()->eq('t.' . $field, ':' . $field));
                $qb->setParameter($field, $value);
                continue;
            }

            $value = str_replace('*', '', $value);
            $value = str_replace('%', '', $value);
            $qb->andWhere($qb->expr()->like('t.' . $field, ':' . $field));
            $qb->setParameter($field, '%' . $value . '%');
        }

        $qb = $this->addPagination($qb, $args);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $args
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getFilteredCount(array $args): int
    {
        return (int) $this->getFilterQuery($args, true)->getQuery()->getSingleScalarResult();
    }

    /**
     * @param array $args
     * @param bool $count
     * @return QueryBuilder
     */
    private function getFilterQuery(array $args, bool $count = false): QueryBuilder
    {
        $alias = 'alias_' . uniqid();

        /* @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getEntityManager();

        if($count) {
            $qb = $em->createQueryBuilder()
                ->select('COUNT('.$alias.'.id)')
                ->from($this->_entityName, $alias);
        } else {
            $qb = $em->createQueryBuilder()
                ->select($alias)
                ->from($this->_entityName, $alias);
        }

        if(array_key_exists('filter', $args)) {
            foreach(array_keys($args['filter']) as $col) {
                if(preg_match('/%/', $args['filter'][$col])) {
                    $qb->where( $qb->expr()->like($alias . '.' . $col, ':' . $col));
                } else {
                    $qb->where( $qb->expr()->eq($alias . '.' . $col, ':' . $col));
                }

                $qb->setParameter($col, $args['filter'][$col]);
            }

        }

        $qb = $this->addPagination($qb, $args);

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param array $args
     * @return QueryBuilder
     */
    public function addPagination(QueryBuilder $qb, array $args): QueryBuilder
    {
        if(array_key_exists('first', $args)) {
            $qb->setMaxResults($args['first']);
        }

        if(array_key_exists('after', $args)) {
            /*
             *   $data = explode('_', base64_decode($args['after']));

            $after = (int) $data[1];
             */

            $after = (int) $args['after'];

            if($after > 0) {
                $qb->setFirstResult($after);
            }
        }

        return $qb;
    }

    /**
     * @param string $field
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCount($field = 'id'): int
    {
        $alias = 'alias_' . uniqid();

        /* @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getEntityManager();

        $qb = $em->createQueryBuilder()->select('count(' . $alias . '.' . $field . ') AS count')
            ->from($this->_entityName, $alias);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

}
