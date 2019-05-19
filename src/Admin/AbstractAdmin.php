<?php

namespace App\Admin;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\AbstractAdmin as BaseAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Abstract class AbstractAdmin
 */
abstract class AbstractAdmin extends BaseAdmin
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var UploaderHelper
     */
    private $vus;

    /**
     * @var CacheManager
     */
    private $lis;

    /**
     * @var array
     */
    protected $perPageOptions = array(25, 50, 100, 200);

    /**
     * @var int
     */
    protected $maxPerPage = 25;

    /**
     * @var string
     */
    protected $translationDomain = 'messages';

    /**
     * Methods.
     */

    /**
     * AbstractAdmin constructor.
     *
     * @param string         $code
     * @param string         $class
     * @param string         $baseControllerName
     * @param EntityManager  $em
     * @param UploaderHelper $vus
     * @param CacheManager   $lis
     */
    public function __construct($code, $class, $baseControllerName, EntityManager $em, UploaderHelper $vus, CacheManager $lis)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->em = $em;
        $this->vus = $vus;
        $this->lis = $lis;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('show')
            ->remove('batch')
            ->remove('delete')
        ;
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

    /**
     * @return array
     */
    public function getExportFormats()
    {
        return array(
            'csv',
            'xls',
        );
    }

    /**
     * @return string
     */
    public function getImageHelperFormMapperWithThumbnail()
    {
        return ($this->getSubject() ?
            $this->getSubject()->getImageName() ?
                '<img src="' . $this->lis->getBrowserPath($this->vus->asset($this->getSubject(), 'imageFile'), '480xY') . '" class="admin-preview img-responsive" style="margin-bottom:5px;" alt="thumbnail"/><a href="'.$this->vus->asset($this->getSubject(), 'imageFile').'" class="btn btn-primary btn-sm" title="download" download><i class="fa fa-download"></i></a>'
                : ''
            : '');
    }

    /**
     * @return bool
     */
    public function formBuilderIsInEditMode()
    {
        return $this->id($this->getSubject());
    }
}
