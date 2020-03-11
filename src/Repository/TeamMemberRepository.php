<?php

namespace App\Repository;

use App\Entity\TeamMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method TeamMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamMember[]    findAll()
 * @method TeamMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamMemberRepository extends ServiceEntityRepository
{
    /**
     * EventCollaboratorRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TeamMember::class);
    }

    /**
     * @return QueryBuilder
     */
    public function findAllSortedBySurnameAndName()
    {
        return $this->createQueryBuilder('tm')
            ->orderBy('tm.surname', 'ASC')
            ->addOrderBy('tm.name', 'ASC')
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findShowInFrontendSortedBySurnameAndName()
    {
        return $this->findAllSortedBySurnameAndName()
            ->andWhere('tm.showInFrontend = :showInFrontend')
            ->setParameter('showInFrontend', true)
        ;
    }
}
