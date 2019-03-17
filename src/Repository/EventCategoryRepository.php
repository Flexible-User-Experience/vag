<?php

namespace App\Repository;

use App\Entity\EventCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventCategory[]    findAll()
 * @method EventCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventCategoryRepository extends ServiceEntityRepository
{
    /**
     * EventCategoryRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventCategory::class);
    }

    /**
     * @return QueryBuilder
     */
    public function findAvailableSortedByPriorityAndName()
    {
        return $this->createQueryBuilder('ec')
            ->andWhere('ec.isAvailable = :val')
            ->setParameter('val', true)
            ->orderBy('ec.priority', 'ASC')
            ->addOrderBy('ec.name', 'ASC')
        ;
    }
}
