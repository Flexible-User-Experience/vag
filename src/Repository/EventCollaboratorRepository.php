<?php

namespace App\Repository;

use App\Entity\EventCollaborator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventCollaborator|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventCollaborator|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventCollaborator[]    findAll()
 * @method EventCollaborator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventCollaboratorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventCollaborator::class);
    }

    // /**
    //  * @return EventCollaborator[] Returns an array of EventCollaborator objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventCollaborator
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
