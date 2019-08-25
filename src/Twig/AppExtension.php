<?php

namespace App\Twig;

use App\Entity\User;
use App\Entity\EventCategory;
use App\Enum\UserRoleEnum;
use App\Repository\ContactMessageRepository;
use App\Service\VichUploadedFilesService;
use DateTimeInterface;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class AppExtension
 */
class AppExtension extends AbstractExtension
{
    /**
     * @var RequestStack service
     */
    private $rss;

    /**
     * @var Translator service
     */
    private $ts;

    /**
     * @var ContactMessageRepository service
     */
    private $cmrs;

    /**
     * @var RouterInterface service
     */
    private $rs;

    /**
     * @var VichUploadedFilesService service
     */
    private $vufs;

    /**
     * @var array
     */
    private $locales;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * Methods.
     */

    /**
     * AppExtension constructor.
     *
     * @param RequestStack             $rss
     * @param TranslatorInterface      $ts
     * @param ContactMessageRepository $cmrs
     * @param RouterInterface          $rs
     * @param VichUploadedFilesService $vufs
     * @param string                   $locales
     * @param string                   $defaultLocale
     */
    public function __construct(RequestStack $rss, TranslatorInterface $ts, ContactMessageRepository $cmrs, RouterInterface $rs, VichUploadedFilesService $vufs, string $locales, string $defaultLocale)
    {
        $this->rss = $rss;
        $this->ts = $ts;
        $this->cmrs = $cmrs;
        $this->rs = $rs;
        $this->vufs = $vufs;
        $this->locales = explode('|', $locales);
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('show_unread_messages', [$this, 'showUnreadMessages']),
        ];
    }

    /**
     * @return string
     *
     * @throws Exception
     */
    public function showUnreadMessages()
    {
        $result = '';
        if ($this->cmrs->getReadPendingMessagesAmount() > 0) {
            $result = '<li class="messages-menu"><a href="'.$this->rs->generate('admin_app_contactmessage_list').'"><i class="fa fa-envelope-o"></i><span class="label label-danger">'.$this->cmrs->getReadPendingMessagesAmount().'</span></a></li>';
        }

        return $result;
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
            new TwigFilter('draw_i18n_date_string', [$this, 'drawI18nDateString']),
            new TwigFilter('draw_image_or_file_cell', [$this, 'drawImageOrFileCell']),
            new TwigFilter('remove_url_protocol', [$this, 'removeUrlProtocol']),
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
                if ($role == UserRoleEnum::ROLE_USER) {
                    $span .= '<span class="label label-primary" style="margin-right:10px;">'.$this->ts->trans('admin.label.role.'.UserRoleEnum::ROLE_USER).'</span>';
                } elseif ($role == UserRoleEnum::ROLE_CMS) {
                    $span .= '<span class="label label-warning" style="margin-right:10px;">'.$this->ts->trans('admin.label.role.'.UserRoleEnum::ROLE_CMS).'</span>';
                } elseif ($role == UserRoleEnum::ROLE_ADMIN) {
                    $span .= '<span class="label label-danger" style="margin-right:10px;">'.$this->ts->trans('admin.label.role.'.UserRoleEnum::ROLE_ADMIN).'</span>';
                }
            }
        } else {
            $span = '<span class="label label-success" style="margin-right:10px;">---</span>';
        }

        return $span;
    }

    /**
     * @param DateTimeInterface $dateTime
     *
     * @return string
     */
    public function drawI18nDateString(DateTimeInterface $dateTime)
    {
        $result = $dateTime->format('d/m/Y');
        if ($this->rss->getCurrentRequest()->getLocale() == 'en') {
            $result = $dateTime->format('m/d/Y');
        }

        return $result;
    }

    /**
     * @param array|object $object
     *
     * @return string
     */
    public function drawImageOrFileCell($object)
    {
        $extension = $this->vufs->getFileExtension($object, 'imageFile');
        if ($this->vufs->isImageFileExtension($extension)) {
            $result = '<img src="'.$this->vufs->getImageFileSrcWithLiipFilter($object, 'imageFile', '60x60').'" class="img-responsive" alt="thumbnail">';
        } else {
            $result = '<a href="'.$this->vufs->getFileSrc($object, 'imageFile').'" class="btn btn-primary btn-sm" title="download" download><i class="fa fa-download"></i></a>';
        }

        return $result;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function removeUrlProtocol(string $url)
    {
        $result = str_replace('http://', '', $url);

        return str_replace('https://', '', $result);
    }
}
