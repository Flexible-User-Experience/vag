<?php

namespace App\Manager;

use App\Entity\EventActivity;
use App\Repository\EventActivityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class EventActivityManager
 */
class EventActivityManager
{
    /**
     * @var RequestStack
     */
    private $rs;

    /**
     * @var EventActivityRepository
     */
    private $ear;

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
     * EventActivityManager constructor.
     *
     * @param RequestStack $rs
     * @param EventActivityRepository $ear
     * @param string $defaultLocale
     */
    public function __construct(RequestStack $rs, EventActivityRepository $ear, string $defaultLocale)
    {
        $this->rs = $rs;
        $this->ear = $ear;
        $this->defaultLocale = $defaultLocale;
        $this->locale = $this->rs->getCurrentRequest()->getLocale();
    }

    /**
     * @param string $slug
     *
     * @return EventActivity|null
     * @throws NonUniqueResultException
     */
    public function getActivityByTranslatedSlug(string $slug)
    {
        if ($this->locale === $this->defaultLocale) {
            $category = $this->ear->findAvailableAndSlug($slug)->getQuery()->getOneOrNullResult();
        } else {
            $category = $this->ear->findLocalizedAvailableAndSlug($this->locale, $slug)->getQuery()->getOneOrNullResult();
        }

        return $category;
    }
}
