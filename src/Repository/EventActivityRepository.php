<?php

namespace App\Repository;

use App\Entity\EventActivity;
use App\Entity\EventCategory;
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
    public function findAvailable()
    {
        return $this->createQueryBuilder('ea')
            ->andWhere('ea.isAvailable = :available')
            ->setParameter('available', true)
        ;
    }

    /**
     * @param string $slug
     *
     * @return QueryBuilder
     */
    public function findAvailableAndSlug(string $slug)
    {
        return $this->findAvailable()
            ->andWhere('ea.slug = :slug')
            ->setParameter('slug', $slug)
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findAvailableSortedByName()
    {
        return $this->findAvailable()
            ->orderBy('ea.name', 'ASC')
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findAvailableForHomepageSortedByName()
    {
        return $this->findAvailableSortedByName()
            ->andWhere('ea.showInHomepage = :homepage')
            ->setParameter('homepage', true)
        ;
    }

    /**
     * @return QueryBuilder
     */
    public function findAvailableForHomepageSortedByBegin()
    {
        return $this->findAvailable()
            ->andWhere('ea.showInHomepage = :homepage')
            ->setParameter('homepage', true)
            ->orderBy('ea.begin', 'DESC')
        ;
    }

    /**
     * @param EventCategory $category
     *
     * @return QueryBuilder
     */
    public function findAvailableByCategorySortedByName(EventCategory $category)
    {
        return $this->createQueryBuilder('ea')
            ->andWhere('ea.isAvailable = :available')
            ->andWhere('ea.category = :category')
            ->setParameter('available', true)
            ->setParameter('category', $category)
            ->orderBy('ea.name', 'ASC')
        ;
    }

    /**
     * @param string $locale
     * @param string $slug
     *
     * @return QueryBuilder
     */
    public function findLocalizedAvailableAndSlug(string $locale, string $slug)
    {
        $qb = $this->findAvailable()
            ->join('ea.translations', 't')
            ->andWhere('t.locale = :locale')
            ->andWhere('t.content = :content')
            ->andWhere('t.field = :field')
            ->setParameter('locale', $locale)
            ->setParameter('content', $slug)
            ->setParameter('field', 'slug')
        ;

        return $qb;
    }
}
