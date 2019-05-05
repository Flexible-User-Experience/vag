<?php

namespace App\EventListener;

use App\Entity\EventActivity;
use App\Entity\EventCategory;
use App\Entity\EventCollaborator;
use App\Entity\EventLocation;
use App\Manager\EventCategoryManager;
use App\Manager\EventActivityManager;
use App\Repository\BlogPostRepository;
use App\Repository\EventCollaboratorRepository;
use App\Repository\EventLocationRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

/**
 * Class SitemapSubscriberEventListener
 */
class SitemapSubscriberEventListener implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var EventCategoryManager
     */
    private $eventCategoryManager;

    /**
     * @var EventActivityManager
     */
    private $eventActivityManager;

    /**
     * @var EventCollaboratorRepository
     */
    private $eventCollaboratorRepository;

    /**
     * @var EventLocationRepository
     */
    private $eventLocationRepository;

    /**
     * @var BlogPostRepository
     */
    private $blogPostRepository;

    /**
     * @var array
     */
    private $locales;

    /**
     * Methods
     */

    /**
     * @param UrlGeneratorInterface       $urlGenerator
     * @param EventCategoryManager        $eventCategoryManager
     * @param EventActivityManager        $eventActivityManager
     * @param EventCollaboratorRepository $eventCollaboratorRepository
     * @param EventLocationRepository     $eventLocationRepository
     * @param BlogPostRepository          $blogPostRepository
     * @param string                      $locales
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, EventCategoryManager $eventCategoryManager, EventActivityManager $eventActivityManager, EventCollaboratorRepository $eventCollaboratorRepository, EventLocationRepository $eventLocationRepository, BlogPostRepository $blogPostRepository, string $locales)
    {
        $this->urlGenerator = $urlGenerator;
        $this->eventCategoryManager = $eventCategoryManager;
        $this->eventActivityManager = $eventActivityManager;
        $this->eventCollaboratorRepository = $eventCollaboratorRepository;
        $this->eventLocationRepository = $eventLocationRepository;
        $this->blogPostRepository = $blogPostRepository;
        $this->locales = explode('|', $locales);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'populate',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     *
     * @throws NonUniqueResultException
     */
    public function populate(SitemapPopulateEvent $event): void
    {
        $section = $event->getSection();
        if (is_null($section) || $section == 'default') {
            /** @var string $locale */
            foreach ($this->locales as $locale) {
                $this->registerFrontendStaticUrls($event->getUrlContainer(), $locale);
                $this->registerFrontendEventCategoriesAndActivities($event->getUrlContainer(), $locale);
                $this->registerFrontendEventCollaborators($event->getUrlContainer(), $locale);
                $this->registerFrontendEventLocations($event->getUrlContainer(), $locale);
            }
        }
    }

    /**
     * @param UrlContainerInterface $urls
     * @param string                $locale
     */
    public function registerFrontendStaticUrls(UrlContainerInterface $urls, string $locale): void
    {
        $urls->addUrl(
            new UrlConcrete(
                $this->urlGenerator->generate(
                    'front_homepage',
                    [
                        '_locale' => $locale,
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ),
            'default'
        );
        /** @var string $route */
        foreach ($this->getStaticRoutesArray() as $route) {
            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        $route.'.'.$locale,
                        [
                            '_locale' => $locale,
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'default'
            );
        }
    }

    /**
     * @return array
     */
    private function getStaticRoutesArray()
    {
        return [
            'front_blog',
            'front_tickets',
            'front_contact',
            'front_team',
            'front_privacy_policy',
        ];
    }

    /**
     * @param UrlContainerInterface $urls
     * @param string $locale
     *
     * @throws NonUniqueResultException
     */
    public function registerFrontendEventCategoriesAndActivities(UrlContainerInterface $urls, string $locale): void
    {
        $categories = $this->eventCategoryManager->getAvailableSortedByPriorityAndName();

        /** @var EventCategory $category */
        foreach ($categories as $category) {
            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'front_event_category',
                        [
                            'slug' => $this->eventCategoryManager->getCategorySlugByLocale($category, $locale),
                            '_locale' => $locale,
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'default'
            );
            $activities = $this->eventActivityManager->getAvailableByCategorySortedByName($category);
            /** @var EventActivity $activity */
            foreach ($activities as $activity) {
                $urls->addUrl(
                    new UrlConcrete(
                        $this->urlGenerator->generate(
                            'front_event_activity.'.$locale,
                            [
                                'category' => $this->eventCategoryManager->getCategorySlugByLocale($category, $locale),
                                'activity' => $this->eventActivityManager->getActivitySlugByLocale($activity, $locale),
                                '_locale' => $locale,
                            ],
                            UrlGeneratorInterface::ABSOLUTE_URL
                        )
                    ),
                    'default'
                );
            }
        }
    }

    /**
     * @param UrlContainerInterface $urls
     * @param string $locale
     *
     * @throws NonUniqueResultException
     */
    public function registerFrontendEventActivities(UrlContainerInterface $urls, string $locale): void
    {

    }

    /**
     * @param UrlContainerInterface $urls
     * @param string $locale
     *
     * @throws NonUniqueResultException
     */
    public function registerFrontendEventCollaborators(UrlContainerInterface $urls, string $locale): void
    {
        $urls->addUrl(
            new UrlConcrete(
                $this->urlGenerator->generate(
                    'front_collaborators.'.$locale,
                    [
                        '_locale' => $locale,
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ),
            'default'
        );

        $collaborators = $this->eventCollaboratorRepository->findAllSortedBySurnameAndName()->getQuery()->getResult();
        /** @var EventCollaborator $collaborator */
        foreach ($collaborators as $collaborator) {
            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'front_collaborator_detail.'.$locale,
                        [
                            'slug' => $collaborator->getSlug(),
                            '_locale' => $locale,
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'default'
            );
        }
    }

    /**
     * @param UrlContainerInterface $urls
     * @param string $locale
     *
     * @throws NonUniqueResultException
     */
    public function registerFrontendEventLocations(UrlContainerInterface $urls, string $locale): void
    {
        $urls->addUrl(
            new UrlConcrete(
                $this->urlGenerator->generate(
                    'front_locations.'.$locale,
                    [
                        '_locale' => $locale,
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ),
            'default'
        );

        $locations = $this->eventLocationRepository->findAllSortedByPlace()->getQuery()->getResult();
        /** @var EventLocation $location */
        foreach ($locations as $location) {
            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'front_location_detail.'.$locale,
                        [
                            'slug' => $location->getSlug(),
                            '_locale' => $locale,
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'default'
            );
        }
    }
}
