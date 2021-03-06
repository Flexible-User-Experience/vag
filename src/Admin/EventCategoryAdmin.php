<?php

namespace App\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class EventCategoryAdmin
 */
final class EventCategoryAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.event_category';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'esdeveniment/categoria';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'priority',
        '_sort_order' => 'ASC',
    );

    /**
     * Methods.
     */

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.with.category', ['class' => 'col-md-4'])
            ->add(
                'color',
                ColorType::class,
                [
                    'label' => 'admin.label.color',
                    'required' => false,
                ]
            )
            ->add(
                'icon',
                TextType::class,
                [
                    'label' => 'admin.label.icon',
                    'help' => 'admin.help.icon',
                    'required' => false,
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'admin.label.name',
                ]
            )
            ->end()
        ;
        if ($this->formBuilderIsInEditMode()) {
            $formMapper
                ->with('admin.with.images', ['class' => 'col-md-4'])
                ->add(
                    'imageFile',
                    FileType::class,
                    [
                        'label' => 'admin.label.image',
                        'help' => $this->getImageHelperFormMapperWithThumbnail(),
                        'required' => false,
                    ]
                )
                ->end()
            ;
        }
        $formMapper
            ->with('admin.with.controls', ['class' => 'col-md-3'])
            ->add(
                'slug',
                TextType::class,
                [
                    'label' => 'admin.label.slug',
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'priority',
                NumberType::class,
                [
                    'label' => 'admin.label.priority',
                ]
            )
            ->add(
                'isAvailable',
                CheckboxType::class,
                [
                    'label' => 'admin.label.is_available_female',
                    'required' => false,
                ]
            )
            ->end()
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'name',
                null,
                [
                    'label' => 'admin.label.name',
                ]
            )
            ->add(
                'priority',
                null,
                [
                    'label' => 'admin.label.priority',
                ]
            )
            ->add(
                'isAvailable',
                null,
                [
                    'label' => 'admin.label.is_available_female',
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add(
                'image',
                null,
                array(
                    'label' => 'admin.label.single_image',
                    'template' => 'backend/cells/list__cell_image_field.html.twig',
                )
            )
            ->add(
                'icon',
                null,
                [
                    'label' => 'admin.label.icon',
                    'template' => 'backend/cells/list__cell_event_category_icon_field.html.twig',
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
                'slug',
                null,
                [
                    'label' => 'admin.label.slug',
                    'editable' => false,
                ]
            )
            ->add(
                'priority',
                null,
                [
                    'label' => 'admin.label.priority',
                    'editable' => true,
                ]
            )
            ->add(
                'isAvailable',
                null,
                [
                    'label' => 'admin.label.is_available_female',
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
