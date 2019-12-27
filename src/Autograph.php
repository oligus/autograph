<?php declare(strict_types=1);

namespace Autograph;

use Autograph\Query\FilterInputCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Annotations\AnnotationException;
use Exception;

/**
 * Class Autograph
 * @package Autograph
 */
class Autograph
{
    private static ?self $instance = null;
    private EntityManagerInterface $em;
    private FilterInputCollection $filterCollection;
    private AnnotationMapper $annotationMapper;

    /**
     * Autograph constructor.
     * @param EntityManagerInterface $em
     * @throws AnnotationException
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->filterCollection = new FilterInputCollection();
        $this->annotationMapper = new AnnotationMapper($em);

        self::$instance = $this;
    }

    /**
     * @return Autograph
     * @throws Exception
     */
    public static function getInstance(): Autograph
    {
        if(!self::$instance instanceof Autograph) {
            throw new Exception('Autograph must be initilized via constructor.');
        }

        return self::$instance;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEm(): EntityManagerInterface
    {
        return $this->em;
    }

    public function getFilterCollection(): FilterInputCollection
    {
        return $this->filterCollection;
    }
}
