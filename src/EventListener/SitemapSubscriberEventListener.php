<?php

namespace App\EventListener;

use App\Entity\EventCategory;
use App\Entity\EventCollaborator;
use App\Manager\EventCategoryManager;
use App\Repository\BlogPostRepository;
use App\Repository\EventActivityRepository;
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
     * @var EventCollaboratorRepository
     */
    private $eventCollaboratorRepository;

    /**
     * @var EventActivityRepository
     */
    private $eventActivityRepository;

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
     * @param EventCollaboratorRepository $eventCollaboratorRepository
     * @param EventActivityRepository     $eventActivityRepository
     * @param EventLocationRepository     $eventLocationRepository
     * @param BlogPostRepository          $blogPostRepository
     * @param string                      $locales
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, EventCategoryManager $eventCategoryManager, EventCollaboratorRepository $eventCollaboratorRepository, EventActivityRepository $eventActivityRepository, EventLocationRepository $eventLocationRepository, BlogPostRepository $blogPostRepository, string $locales)
    {
        $this->urlGenerator = $urlGenerator;
        $this->eventCategoryManager = $eventCategoryManager;
        $this->eventCollaboratorRepository = $eventCollaboratorRepository;
        $this->eventActivityRepository = $eventActivityRepository;
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
                $this->registerFrontendEventCategories($event->getUrlContainer(), $locale);
                $this->registerFrontendEventCollaborators($event->getUrlContainer(), $locale);
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
        $urls->addUrl(
            new UrlConcrete(
                $this->urlGenerator->generate(
                    'front_blog',
                    [
                        '_locale' => $locale,
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ),
            'default'
        );
        $urls->addUrl(
            new UrlConcrete(
                $this->urlGenerator->generate(
                    'front_tickets',
                    [
                        '_locale' => $locale,
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ),
            'default'
        );
        $urls->addUrl(
            new UrlConcrete(
                $this->urlGenerator->generate(
                    'front_contact',
                    [
                        '_locale' => $locale,
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ),
            'default'
        );
        $urls->addUrl(
            new UrlConcrete(
                $this->urlGenerator->generate(
                    'front_team',
                    [
                        '_locale' => $locale,
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ),
            'default'
        );
    }

    /**
     * @param UrlContainerInterface $urls
     * @param string $locale
     *
     * @throws NonUniqueResultException
     */
    public function registerFrontendEventCategories(UrlContainerInterface $urls, string $locale): void
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
        }
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
                    'front_collaborators',
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
                        'front_collaborator_detail',
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
}
