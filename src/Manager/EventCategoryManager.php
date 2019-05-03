<?php

namespace App\Manager;

use App\Entity\EventCategory;
use App\Repository\EventCategoryRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class EventCategoryManager
 */
class EventCategoryManager
{
    /**
     * @var RequestStack
     */
    private $rs;

    /**
     * @var EventCategoryRepository
     */
    private $ecr;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var string
     */
    private $locale;

    /**
     * Methods
     */

    /**
     * EventCategoryManager constructor.
     *
     * @param RequestStack $rs
     * @param EventCategoryRepository $ecr
     * @param string $defaultLocale
     */
    public function __construct(RequestStack $rs, EventCategoryRepository $ecr, string $defaultLocale)
    {
        $this->rs = $rs;
        $this->ecr = $ecr;
        $this->defaultLocale = $defaultLocale;
        $this->locale = $this->rs->getCurrentRequest()->getLocale();
    }

    /**
     * @param string $slug
     *
     * @return EventCategory|null
     * @throws NonUniqueResultException
     */
    public function getCategoryByTranslatedSlug(string $slug)
    {
        if ($this->locale === $this->defaultLocale) {
            $category = $this->ecr->findAvailableAndSlugSortedByPriorityAndName($slug)->getQuery()->getOneOrNullResult();
        } else {
            $category = $this->ecr->findLocalizedSlugAvailableSortedByPriorityAndName($this->locale, $slug)->getQuery()->getOneOrNullResult();
        }

        return $category;
    }

    /**
     * @param EventCategory $category
     * @param string        $locale
     *
     * @return EventCategory|null
     * @throws NonUniqueResultException
     */
    public function getCategorySlugByLocale(EventCategory $category, $locale)
    {
        $slug = $category->getSlug();
        if ($locale !== $this->defaultLocale) {
            $slug = $this->ecr->findLocalizedSlugByLocaleAndCategory($locale, $category)->getQuery()->getSingleScalarResult();
        }

        return $slug;
    }

    /**
     * @return EventCategory[]|null
     */
    public function getAvailableSortedByPriorityAndName()
    {
        return $this->ecr->findAvailableSortedByPriorityAndName()->getQuery()->getResult();
    }
}
