<?php

namespace App\Admin;

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
     * @param string $code
     * @param string $class
     * @param string $baseControllerName
     * @param EntityManager $em
     */
    public function __construct($code, $class, $baseControllerName, EntityManager $em)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->em = $em;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('show')
            ->remove('batch')
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

}
