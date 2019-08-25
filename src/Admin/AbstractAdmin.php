<?php

namespace App\Admin;

use App\Service\VichUploadedFilesService;
use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\AbstractAdmin as BaseAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

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
     * @var VichUploadedFilesService
     */
    protected $vufs;

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
     * @param VichUploadedFilesService $vufs
     */
    public function __construct($code, $class, $baseControllerName, EntityManager $em, VichUploadedFilesService $vufs)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->em = $em;
        $this->vufs = $vufs;
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
        $result = '';
        $extension = $this->vufs->getFileExtension($this->getSubject(), 'imageFile');
        if ($this->vufs->isImageFileExtension($extension)) {
            $result = '<img src="'.$this->vufs->getImageFileSrcWithLiipFilter($this->getSubject(), 'imageFile', '480xY').'" class="img-responsive" alt="thumbnail">';
        }
        $result .= '<a href="'.$this->vufs->getFileSrc($this->getSubject(), 'imageFile').'" class="btn btn-primary btn-sm" title="download" download><i class="fa fa-download"></i></a>';


        return $result;
    }

    /**
     * @return bool
     */
    public function formBuilderIsInEditMode()
    {
        return $this->id($this->getSubject());
    }
}
