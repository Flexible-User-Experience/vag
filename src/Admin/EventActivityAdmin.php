<?php

namespace App\Admin;

use App\Entity\EventCategory;
use App\Entity\EventCollaborator;
use App\Entity\EventLocation;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\BooleanType;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class EventActivityAdmin
 */
final class EventActivityAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.event_activity';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'esdeveniment/activitat';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'begin',
        '_sort_order' => 'DESC',
    );

    /**
     * Methods.
     */

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('admin.with.activity', ['class' => 'col-md-5'])
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'admin.label.name',
                ]
            )
            ->add(
                'shortDescription',
                TextType::class,
                [
                    'label' => 'admin.label.short_description',
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'admin.label.description',
                    'attr' => [
                        'rows' => '5',
                        'style' => 'resize:vertical',
                    ],
                ]
            )
            ->end()
            ->with('admin.with.relations', ['class' => 'col-md-4'])
            ->add(
                'category',
                EntityType::class,
                [
                    'label' => 'admin.label.category',
                    'class' => EventCategory::class,
                ]
            )
            ->add(
                'location',
                EntityType::class,
                [
                    'label' => 'admin.label.location',
                    'class' => EventLocation::class,
                ]
            )
            ->add(
                'collaborators',
                EntityType::class,
                [
                    'label' => 'admin.label.collaborators',
                    'class' => EventCollaborator::class,
                    'multiple' => true,
                ]
            )
            ->end()
            ->with('admin.with.controls', ['class' => 'col-md-3'])
            ->add(
                'begin',
                DateTimePickerType::class,
                [
                    'label' => 'admin.label.begin',
                    'format' => 'd/M/y HH:mm',
                    'required' => true,
                ]
            )
            ->add(
                'end',
                DateTimePickerType::class,
                [
                    'label' => 'admin.label.end',
                    'format' => 'd/M/y HH:mm',
                    'required' => true,
                ]
            )
            ->add(
                'isAvailable',
                BooleanType::class,
                [
                    'label' => 'admin.label.is_available',
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
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {
        unset($this->listModes['mosaic']);
        $listMapper
            ->add(
                'begin',
                'date',
                [
                    'label' => 'admin.label.begin',
                    'format' => 'd/m/Y H:i',
                    'editable' => false,
                ]
            )
            ->add(
                'name',
                null,
                [
                    'label' => 'admin.label.name',
                    'editable' => true,
                ]
            )
            ->add(
                'category',
                null,
                [
                    'label' => 'admin.label.category',
                    'editable' => false,
                    'associated_property' => 'name',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'name'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'category')),
                ]
            )
            ->add(
                'location',
                null,
                [
                    'label' => 'admin.label.location',
                    'editable' => false,
                    'associated_property' => 'place',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'place'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'location')),
                ]
            )
            ->add(
                'isAvailable',
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