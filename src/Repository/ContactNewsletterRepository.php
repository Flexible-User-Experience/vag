<?php

namespace App\Repository;

use App\Entity\ContactNewsletter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContactNewsletter|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactNewsletter|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactNewsletter[]    findAll()
 * @method ContactNewsletter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactNewsletterRepository extends ServiceEntityRepository
{
    /**
     * EventCollaboratorRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContactNewsletter::class);
    }
}
