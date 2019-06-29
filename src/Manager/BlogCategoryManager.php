<?php

namespace App\Manager;

use App\Entity\BlogCategory;
use App\Repository\BlogCategoryRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class BlogCategoryManager
 */
class BlogCategoryManager
{
    /**
     * @var RequestStack
     */
    private $rs;

    /**
     * @var BlogCategoryRepository
     */
    private $bcr;

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
     * BlogCategoryManager constructor.
     *
     * @param RequestStack $rs
     * @param BlogCategoryRepository $bcr
     * @param string $defaultLocale
     */
    public function __construct(RequestStack $rs, BlogCategoryRepository $bcr, string $defaultLocale)
    {
        $this->rs = $rs;
        $this->bcr = $bcr;
        $this->defaultLocale = $defaultLocale;
        $this->locale = $this->rs->getCurrentRequest() ? $this->rs->getCurrentRequest()->getLocale() : $defaultLocale;
    }

    /**
     * @param string $slug
     *
     * @return BlogCategory|null
     * @throws NonUniqueResultException
     */
    public function getTagByTranslatedSlug(string $slug)
    {
        if ($this->locale === $this->defaultLocale) {
            $category = $this->bcr->findAvailableAndSlugSortedByName($slug)->getQuery()->getOneOrNullResult();
        } else {
            $category = $this->bcr->findLocalizedSlugAvailableSortedByName($this->locale, $slug)->getQuery()->getOneOrNullResult();
        }

        return $category;
    }
}
