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
            new TwigFilter('category_icon', [$this, 'drawEventCategoryIcon']),
        ];
    }

    /**
     * @param EventCategory $category
     *
     * @return string
     */
    public function drawEventCategoryIcon(EventCategory $category)
    {
        return '<i class="'.$category->getIcon().'" style="color:'.$category->getColor().'"></i>';
    }
}
