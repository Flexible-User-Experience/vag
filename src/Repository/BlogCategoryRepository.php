<?php

namespace App\Repository;

use App\Entity\BlogCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BlogCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogCategory[]    findAll()
 * @method BlogCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogCategoryRepository extends ServiceEntityRepository
{
    /**
     * EventCategoryRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogCategory::class);
    }

    /**
     * @return QueryBuilder
     */
    public function findAvailableSortedByName()
    {
        return $this->createQueryBuilder('bc')
            ->andWhere('bc.isAvailable = :available')
            ->setParameter('available', true)
            ->orderBy('bc.name', 'ASC')
        ;
    }
}
