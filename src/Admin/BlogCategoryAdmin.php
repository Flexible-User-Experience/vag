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
 * Class BlogCategoryAdmin
 */
final class BlogCategoryAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.blog_category';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'blog/categoria';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'name',
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
