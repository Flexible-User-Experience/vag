<?php

namespace App\Twig;

use App\Entity\User;
use App\Entity\EventCategory;
use App\Enum\UserRoleEnum;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class AppExtension
 */
class AppExtension extends AbstractExtension
{
    /**
     * @var array
     */
    private $locales;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * Methods
     */

    /**
     * AppExtension constructor.
     *
     * @param array  $locales
     * @param string $defaultLocale
     */
    public function __construct($locales, $defaultLocale)
    {
        $this->locales = $locales;
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @return array|TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('icon', [$this, 'drawEventCategoryIcon']),
            new TwigFilter('icon_colored', [$this, 'drawEventCategoryIconWithColor']),
            new TwigFilter('draw_role_span', [$this, 'drawRoleSpan']),
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

    /**
     * @param User $object
     *
     * @return string
     */
    public function drawRoleSpan($object)
    {
        $span = '';
        if ($object instanceof User && count($object->getRoles()) > 0) {
            /** @var string $role */
            foreach ($object->getRoles() as $role) {
                if ($role == UserRoleEnum::ROLE_CMS) {
                    $span .= '<span class="label label-warning" style="margin-right:10px">editor</span>';
                } elseif ($role == UserRoleEnum::ROLE_USER) {
                    $span .= '<span class="label label-primary" style="margin-right:10px">administrador</span>';
                } elseif ($role == UserRoleEnum::ROLE_ADMIN) {
                    $span .= '<span class="label label-danger" style="margin-right:10px">superadministrador</span>';
                }
            }
        } else {
            $span = '<span class="label label-success" style="margin-right:10px">---</span>';
        }

        return $span;
    }
}
