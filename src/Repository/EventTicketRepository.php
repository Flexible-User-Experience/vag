<?php

namespace App\Repository;

use App\Entity\EventCategory;
use App\Entity\EventTicket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventCategory[]    findAll()
 * @method EventCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventTicketRepository extends ServiceEntityRepository
{
    /**
     * EventCategoryRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventTicket::class);
    }
}
