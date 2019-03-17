<?php

namespace App\Repository;

use App\Entity\EventActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventActivity[]    findAll()
 * @method EventActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventActivityRepository extends ServiceEntityRepository
{
    /**
     * EventActivityRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventActivity::class);
    }

    /**
     * @return QueryBuilder
     */
    public function findAvailableSortedByName()
    {
        return $this->createQueryBuilder('ea')
            ->andWhere('ea.isAvailable = :val')
            ->setParameter('val', true)
            ->orderBy('ea.name', 'ASC')
        ;
    }
}
