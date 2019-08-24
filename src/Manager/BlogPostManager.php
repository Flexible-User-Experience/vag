<?php

namespace App\Manager;

use App\Entity\BlogPost;
use App\Repository\BlogPostRepository;
use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class BlogPostManager
 */
class BlogPostManager
{
    /**
     * @var RequestStack
     */
    private $rs;

    /**
     * @var BlogPostRepository
     */
    private $bpr;

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
     * @param BlogPostRepository $bpr
     * @param string $defaultLocale
     */
    public function __construct(RequestStack $rs, BlogPostRepository $bpr, string $defaultLocale)
    {
        $this->rs = $rs;
        $this->bpr = $bpr;
        $this->defaultLocale = $defaultLocale;
        $this->locale = $this->rs->getCurrentRequest() ? $this->rs->getCurrentRequest()->getLocale() : $defaultLocale;
    }

    /**
     * @param DateTime $published
     * @param string $slug
     *
     * @return BlogPost|null
     * @throws NonUniqueResultException
     */
    public function getPostByTranslatedSlug(DateTime $published, string $slug)
    {
        if ($this->locale === $this->defaultLocale) {
            $category = $this->bpr->findByPublishedAndSlug($published, $slug)->getQuery()->getOneOrNullResult();
        } else {
            $category = $this->bpr->findByPublishedAndLocalizedSlug($published, $this->locale, $slug)->getQuery()->getOneOrNullResult();
        }

        return $category;
    }
}
