<?php

namespace App\Repository;

use App\Entity\EventCollaborator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method EventCollaborator|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventCollaborator|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventCollaborator[]    findAll()
 * @method EventCollaborator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventCollaboratorRepository extends ServiceEntityRepository
{
    /**
     * EventCollaboratorRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventCollaborator::class);
    }

    /**
     * @return QueryBuilder
     */
    public function findAllSortedBySurnameAndName()
    {
        return $this->createQueryBuilder('ec')
            ->orderBy('ec.surname', 'ASC')
            ->addOrderBy('ec.name', 'ASC')
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findAvailableSortedBySurnameAndName()
    {
        return $this->findAllSortedBySurnameAndName()
            ->andWhere('ec.isAvailable = :isAvailable')
            ->setParameter('isAvailable', true)
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findShowInHomepageSortedBySurnameAndName()
    {
        return $this->findAllSortedBySurnameAndName()
            ->andWhere('ec.showInHomepage = :showInHomepage')
            ->setParameter('showInHomepage', true)
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findAvailableAndShowInHomepageSortedBySurnameAndName()
    {
        return $this->findShowInHomepageSortedBySurnameAndName()
            ->andWhere('ec.isAvailable = :isAvailable')
            ->setParameter('isAvailable', true)
        ;
    }
}
