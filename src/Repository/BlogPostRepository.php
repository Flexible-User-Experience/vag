<?php

namespace App\Repository;

use App\Entity\BlogCategory;
use App\Entity\BlogPost;
use DateTime;
use DateTimeImmutable;
use Exception;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostRepository extends ServiceEntityRepository
{
    /**
     * EventCategoryRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    /**
     * @return QueryBuilder
     */
    public function findAvailableSortedByPublishedDateAndName()
    {
        return $this->createQueryBuilder('bp')
            ->where('bp.isAvailable = :available')
            ->setParameter('available', true)
            ->orderBy('bp.published', 'DESC')
            ->addOrderBy('bp.name', 'ASC')
        ;
    }

    /**
     * @return QueryBuilder
     *
     * @throws Exception
     */
    public function findUpTodayAvailableSortedByPublishedDateAndName()
    {
        $today = new DateTimeImmutable();

        return $this->findAvailableSortedByPublishedDateAndName()
            ->andWhere('DATE(bp.published) <= DATE(:today)')
            ->setParameter('today', $today)
        ;
    }

    /**
     * @param BlogCategory $category
     *
     * @return QueryBuilder
     *
     * @throws Exception
     */
    public function findUpTodayAvailableSortedByPublishedDateNameAndTag(BlogCategory $category)
    {
        return $this->findUpTodayAvailableSortedByPublishedDateAndName()
            ->innerJoin('bp.tags', 'bc')
            ->andWhere('bc.id = :id')
            ->setParameter('id', $category->getId())
        ;
    }

    /**
     * @param DateTime $published
     * @param string $slug
     *
     * @return QueryBuilder
     */
    public function findByPublishedAndSlug(DateTime $published, string $slug)
    {
        return $this->createQueryBuilder('bp')
            ->where('bp.slug = :slug')
            ->andWhere('DATE(bp.published) <= DATE(:published)')
            ->setParameter('slug', $slug)
            ->setParameter('published', $published)
        ;
    }

    /**
     * @param DateTime $published
     * @param string $locale
     * @param string $slug
     *
     * @return QueryBuilder
     */
    public function findByPublishedAndLocalizedSlug(DateTime $published, string $locale, string $slug)
    {
        return $this->createQueryBuilder('bp')
            ->join('bp.translations', 't')
            ->where('DATE(bp.published) <= DATE(:published)')
            ->andWhere('t.locale = :locale')
            ->andWhere('t.content = :content')
            ->andWhere('t.field = :field')
            ->setParameter('published', $published)
            ->setParameter('locale', $locale)
            ->setParameter('content', $slug)
            ->setParameter('field', 'slug')
        ;
    }
}
