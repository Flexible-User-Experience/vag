<?php

namespace App\Repository;

use App\Entity\TeamPartner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method TeamPartner|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamPartner|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamPartner[]    findAll()
 * @method TeamPartner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamPartnerRepository extends ServiceEntityRepository
{
    /**
     * EventCollaboratorRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TeamPartner::class);
    }

    /**
     * @return QueryBuilder
     */
    public function findAllSortedByName()
    {
        return $this->createQueryBuilder('tp')
            ->orderBy('tp.name', 'ASC')
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findShowInFrontendSortedByName()
    {
        return $this->findAllSortedByName()
            ->andWhere('tp.showInFrontend = :showInFrontend')
            ->setParameter('showInFrontend', true)
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findOnlyPartnersShowInFrontendSortedByName()
    {
        return $this->findShowInFrontendSortedByName()
            ->andWhere('tp.isCollaborator = :isCollaborator')
            ->setParameter('isCollaborator', false)
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findOnlyCollaboratorsShowInFrontendSortedByName()
    {
        return $this->findShowInFrontendSortedByName()
            ->andWhere('tp.isCollaborator = :isCollaborator')
            ->setParameter('isCollaborator', true)
        ;
    }
}
