<?php

namespace App\Repository;

use App\Entity\EventLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventLocation[]    findAll()
 * @method EventLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventLocationRepository extends ServiceEntityRepository
{
    /**
     * EventLocationRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventLocation::class);
    }

    /**
     * @return QueryBuilder
     */
    public function findAllSortedByPlace()
    {
        return $this->createQueryBuilder('el')
            ->orderBy('el.place', 'ASC')
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findShowInHomepageSortedByPlace()
    {
        return $this->findAllSortedByPlace()
            ->where('el.showInHomepage = :showInHomepage')
            ->setParameter('showInHomepage', true)
            ->orderBy('el.place', 'ASC')
        ;
    }
}
