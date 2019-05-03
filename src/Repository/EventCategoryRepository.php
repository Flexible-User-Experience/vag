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
            ->andWhere('ec.isAvailable = :available')
            ->setParameter('available', true)
            ->orderBy('ec.priority', 'ASC')
            ->addOrderBy('ec.name', 'ASC')
        ;
    }

    /**
     * @param string $slug
     *
     * @return QueryBuilder
     */
    public function findAvailableAndSlugSortedByPriorityAndName(string $slug)
    {
        return $this->findAvailableSortedByPriorityAndName()
            ->andWhere('ec.slug = :slug')
            ->setParameter('slug', $slug)
        ;
    }

    /**
     * @param string $locale
     * @param string $slug
     *
     * @return QueryBuilder
     */
    public function findLocalizedSlugAvailableSortedByPriorityAndName(string $locale, string $slug)
    {
        $qb = $this->findAvailableSortedByPriorityAndName()
            ->join('ec.translations', 't')
            ->andWhere('t.locale = :locale')
            ->andWhere('t.content = :content')
            ->andWhere('t.field = :field')
            ->setParameter('locale', $locale)
            ->setParameter('content', $slug)
            ->setParameter('field', 'slug')
        ;

        return $qb;
    }

    /**
     * @param string        $locale
     * @param EventCategory $category
     *
     * @return QueryBuilder
     */
    public function findLocalizedSlugByLocaleAndCategory(string $locale, EventCategory $category)
    {
        $qb = $this->createQueryBuilder('ec')
            ->select('t.content')
            ->join('ec.translations', 't')
            ->andWhere('t.locale = :locale')
            ->andWhere('t.object = :category')
            ->andWhere('t.field = :field')
            ->setParameter('locale', $locale)
            ->setParameter('category', $category)
            ->setParameter('field', 'slug')
        ;

        return $qb;
    }
}
