<?php

namespace App\Repository;

use App\Entity\ContactMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method ContactMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactMessage[]    findAll()
 * @method ContactMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactMessageRepository extends ServiceEntityRepository
{
    /**
     * EventCollaboratorRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContactMessage::class);
    }

    /**
     * @return int
     *
     * @throws NonUniqueResultException
     */
    public function getReadPendingMessagesAmount()
    {
        $qb = $this->createQueryBuilder('cm')
            ->select('COUNT(cm.id)')
            ->where('cm.hasBeenReaded = :checked')
            ->setParameter('checked', false)
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }
}
