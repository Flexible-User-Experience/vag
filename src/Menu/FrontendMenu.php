<?php

namespace App\Menu;

use App\Entity\EventCategory;
use App\Repository\EventCategoryRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class FrontendMenu
 */
class FrontendMenu
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var EventCategoryRepository
     */
    private $ecr;

    /**
     * Methods
     */

    /**
     * @param FactoryInterface $factory
     * @param TranslatorInterface $translator
     * @param EventCategoryRepository $ecr
     */
    public function __construct(FactoryInterface $factory, TranslatorInterface $translator, EventCategoryRepository $ecr)
    {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->ecr = $ecr;
    }

    /**
     * @return ItemInterface
     */
    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav ml-auto flex-nowrap');
        // events
        $eventCategories = $this->ecr->findAvailableSortedByPriorityAndName()->getQuery()->getResult();
        /** @var EventCategory $category */
        foreach ($eventCategories as $category) {
            $item = $menu->addChild(
                $category->getSlug(),
                [
                    'label' => $category->getName(),
                    'route' => 'front_event_category',
                    'routeParameters' => [
                        'slug' => $category->getSlug(),
                    ],
                ]
            );
            $item->setAttribute('class', 'nav-item');
            $item->setLinkAttribute('class', 'nav-link');
        }
        // blog
        $item = $menu->addChild(
            'front.menu.blog',
            [
                'label' => $this->translator->trans('front.menu.blog'),
                'route' => 'front_blog',
            ]
        );
        $item->setAttribute('class', 'nav-item');
        $item->setLinkAttribute('class', 'nav-link');
        // tickets
        $item = $menu->addChild(
            'front.menu.tickets',
            [
                'label' => $this->translator->trans('front.menu.tickets'),
                'route' => 'front_tickets',
            ]
        );
        $item->setAttribute('class', 'nav-item');
        $item->setLinkAttribute('class', 'nav-link btn btn-outline-secondary');

        return $menu;
    }
}
