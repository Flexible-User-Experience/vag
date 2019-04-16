<?php

namespace App\Admin;

use App\Enum\UserRoleEnum;
use Sonata\UserBundle\Admin\Model\UserAdmin as ParentUserAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class EventLocationAdmin
 */
final class UserAdmin extends ParentUserAdmin
{
    /**
     * @var string
     */
    protected $translationDomain = 'messages';

    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.user';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'configuracio/usuari';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'username',
        '_sort_order' => 'asc',
    );

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * Methods.
     */

    /**
     * UserAdmin constructor.
     *
     * @param string               $code
     * @param string               $class
     * @param string               $baseControllerName
     * @param UserManagerInterface $userManager
     */
    public function __construct($code, $class, $baseControllerName, $userManager)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->userManager = $userManager;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('batch')
            ->remove('export')
            ->remove('show')
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
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('admin.with.user', array('class' => 'col-md-6'))
            ->add(
                'username',
                TextType::class,
                [
                    'label' => 'admin.label.username',
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'admin.label.email',
                ]
            )
            ->add(
                'plainPassword',
                TextType::class,
                [
                    'label' => 'admin.label.plain_password',
                    'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
                ]
            )
            ->end()
            ->with('admin.with.controls', array('class' => 'col-md-6'))
            ->add(
                'enabled',
                CheckboxType::class,
                [
                    'label' => 'admin.label.is_available',
                    'required' => false,
                ]
            )
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'label' => 'admin.label.user_roles',
                    'choices' => UserRoleEnum::getStaticChoices(),
                    'multiple' => true,
                    'expanded' => true,
                ]
            )
            ->end()
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add(
                'username',
                null,
                [
                    'label' => 'admin.label.username',
                ]
            )
            ->add(
                'email',
                null,
                [
                    'label' => 'admin.label.email',
                ]
            )
//            ->add(
//                'roles',
//                ChoiceFilter::class,
//                array(
//                    'label' => 'admin.label.user_roles',
//                    'field_type' => 'choice',
//                    'field_options' => array(
//                        'choices' => UserRoleEnum::getStaticChoices(),
//                    ),
//                )
//            )
            ->add(
                'enabled',
                null,
                [
                    'label' => 'backend.admin.is_available',
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add(
                'username',
                null,
                [
                    'label' => 'admin.label.username',
                    'editable' => true,
                ]
            )
            ->add(
                'email',
                null,
                [
                    'label' => 'admin.label.email',
                    'editable' => true,
                ]
            )
            ->add(
                'roles',
                null,
                [
                    'label' => 'admin.label.user_roles',
                    'template' => 'backend/cells/list__cell_user_roles.html.twig',
                ]
            )
            ->add(
                'enabled',
                null,
                [
                    'label' => 'admin.label.is_available',
                    'editable' => true,
                ]
            )
            ->add(
                '_action',
                null,
                [
                    'label' => 'admin.label.actions',
                    'actions' => [
                        'edit' => [],
                    ],
                ]
            )
        ;
    }
}
