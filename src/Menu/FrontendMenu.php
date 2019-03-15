<?php

namespace App\Menu;

use App\Entity\EventCategory;
use App\Repository\EventCategoryRepository;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

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
     * @var EventCategoryRepository
     */
    private $ecr;

    /**
     * Methods
     */

    /**
     * @param FactoryInterface $factory
     * @param EventCategoryRepository $ecr
     */
    public function __construct(FactoryInterface $factory, EventCategoryRepository $ecr)
    {
        $this->factory = $factory;
        $this->ecr = $ecr;
    }

    /**
     * @return ItemInterface
     */
    public function createMainMenu()
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav ml-auto flex-nowrap');

        $eventCategories = $this->ecr->findEnabledSortedByName();
        /** @var EventCategory $category */
        foreach ($eventCategories as $category) {
            $item = $menu->addChild($category->getName(), ['label' => $category->getName(), 'uri' => '#']);
            $item->setAttribute('class', 'nav-item');
            $item->setLinkAttribute('class', 'nav-link');
        }

        return $menu;
    }
}
