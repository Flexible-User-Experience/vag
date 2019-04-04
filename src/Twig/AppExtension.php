<?php

namespace App\Twig;

use App\Entity\EventCategory;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class AppExtension
 */
class AppExtension extends AbstractExtension
{
    /**
     * @return array|TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('icon', [$this, 'drawEventCategoryIcon']),
            new TwigFilter('icon_colored', [$this, 'drawEventCategoryIconWithColor']),
        ];
    }

    /**
     * @param EventCategory $category
     *
     * @return string
     */
    public function drawEventCategoryIcon(EventCategory $category)
    {
        return '<i class="'.$category->getIcon().'"></i>';
    }

    /**
     * @param EventCategory $category
     *
     * @return string
     */
    public function drawEventCategoryIconWithColor(EventCategory $category)
    {
        return '<i class="'.$category->getIcon().'" style="color:'.$category->getColor().'"></i>';
    }
}
