<?php

namespace App\Admin;

use App\Entity\EventCategory;
use App\Entity\EventCollaborator;
use App\Entity\EventLocation;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                    'query_builder' => $this->em->getRepository(EventCategory::class)->findAvailableSortedByPriorityAndName(),
                ]
            )
            ->add(
                'location',
                EntityType::class,
                [
                    'label' => 'admin.label.location',
                    'class' => EventLocation::class,
                    'query_builder' => $this->em->getRepository(EventLocation::class)->findAllSortedByPlace(),
                ]
            )
            ->add(
                'collaborators',
                EntityType::class,
                [
                    'label' => 'admin.label.collaborators',
                    'class' => EventCollaborator::class,
                    'query_builder' => $this->em->getRepository(EventCollaborator::class)->findAllSortedBySurnameAndName(),
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
                'showInHomepage',
                CheckboxType::class,
                [
                    'label' => 'admin.label.show_in_homepage',
                    'required' => false,
                ]
            )
            ->add(
                'isAvailable',
                CheckboxType::class,
                [
                    'label' => 'admin.label.is_available',
                    'required' => false,
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
                'begin',
                DateFilter::class,
                array(
                    'label' => 'admin.label.begin',
                    'field_type' => DateTimePickerType::class,
                    'format' => 'd/m/Y H:i',
                ),
                null,
                array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                )
            )
            ->add(
                'end',
                DateFilter::class,
                array(
                    'label' => 'admin.label.end',
                    'field_type' => DateTimePickerType::class,
                    'format' => 'd/m/Y H:i',
                ),
                null,
                array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                )
            )
            ->add(
                'name',
                null,
                [
                    'label' => 'admin.label.name',
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
            ->add(
                'category',
                null,
                [
                    'label' => 'admin.label.category',
                ],
                EntityType::class,
                [
                    'class' => EventCategory::class,
                    'query_builder' => $this->em->getRepository(EventCategory::class)->findAvailableSortedByPriorityAndName(),
                ]
            )
            ->add(
                'location',
                null,
                [
                    'label' => 'admin.label.location',
                ],
                EntityType::class,
                [
                    'class' => EventLocation::class,
                    'query_builder' => $this->em->getRepository(EventLocation::class)->findAllSortedByPlace(),
                ]
            )
            ->add(
                'collaborators',
                null,
                [
                    'label' => 'admin.label.collaborators',
                ],
                EntityType::class,
                [
                    'class' => EventCollaborator::class,
                    'query_builder' => $this->em->getRepository(EventCollaborator::class)->findAllSortedBySurnameAndName(),
                ]
            )
            ->add(
                'showInHomepage',
                null,
                [
                    'label' => 'admin.label.show_in_homepage_short',
                ]
            )
            ->add(
                'isAvailable',
                null,
                [
                    'label' => 'admin.label.is_available',
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
                'showInHomepage',
                null,
                [
                    'label' => 'admin.label.show_in_homepage_short',
                    'editable' => true,
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
