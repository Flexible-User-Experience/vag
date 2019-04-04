<?php

namespace App\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class EventCollaboratorAdmin
 */
final class EventCollaboratorAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.event_collaborator';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'esdeveniment/col-laborador';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'surname',
        '_sort_order' => 'ASC',
    );

    /**
     * Methods.
     */

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('admin.with.collaborator', ['class' => 'col-md-4'])
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'admin.label.name',
                ]
            )
            ->add(
                'surname',
                TextType::class,
                [
                    'label' => 'admin.label.surname',
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
                'phone',
                TextType::class,
                [
                    'label' => 'admin.label.phone',
                ]
            )
            ->end()
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper  $datagridMapper)  {
        $datagridMapper
            ->add(
                'name',
                null,
                [
                    'label' => 'admin.label.name',
                ]
            )
            ->add(
                'surname',
                null,
                [
                    'label' => 'admin.label.surname',
                ]
            )
            ->add(
                'email',
                null,
                [
                    'label' => 'admin.label.email',
                ]
            )
            ->add(
                'phone',
                null,
                [
                    'label' => 'admin.label.phone',
                ]
            )
            ->add(
                'shortDescription',
                null,
                [
                    'label' => 'admin.label.short_description',
                ]
            )
            ->add(
                'description',
                null,
                [
                    'label' => 'admin.label.description',
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->add(
                'name',
                null,
                [
                    'label' => 'admin.label.name',
                    'editable' => true,
                ]
            )
            ->add(
                'surname',
                null,
                [
                    'label' => 'admin.label.surname',
                    'editable' => true,
                ]
            )
            ->add(
                'slug',
                null,
                [
                    'label' => 'admin.label.slug',
                    'editable' => false,
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
                'showInHomepage',
                null,
                [
                    'label' => 'admin.label.show_in_homepage_short',
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
