<?php

namespace App\Admin;

use App\Entity\BlogCategory;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;
use Sonata\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class BlogPostAdmin
 */
final class BlogPostAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.blog_post';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'blog/article';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'published',
        '_sort_order' => 'DESC',
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
            ->with('admin.with.post', ['class' => 'col-md-4'])
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'admin.label.name',
                ]
            )
            ->add(
                'shortDescription',
                CKEditorType::class,
                [
                    'label' => 'admin.label.short_description',
                    'required' => false,
                    'config' => [
                        'language' => $this->getRequest()->getLocale(),
                    ],
                    'attr' => [
                        'rows' => '5',
                        'style' => 'resize:vertical',
                    ],
                ]
            )
            ->add(
                'description',
                CKEditorType::class,
                [
                    'label' => 'admin.label.description',
                    'required' => false,
                    'config' => [
                        'language' => $this->getRequest()->getLocale(),
                    ],
                    'attr' => [
                        'rows' => '5',
                        'style' => 'resize:vertical',
                    ],
                ]
            )
            ->end()
        ;
        if ($this->formBuilderIsInEditMode()) {
            $formMapper->
                with('admin.with.images', ['class' => 'col-md-4'])
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
                'published',
                DatePickerType::class,
                [
                    'label' => 'admin.label.published',
                    'format' => 'd/M/y',
                    'required' => true,
                ]
            )
            ->add(
                'tags',
                EntityType::class,
                [
                    'label' => 'admin.label.blog_tags',
                    'class' => BlogCategory::class,
                    'query_builder' => $this->em->getRepository(BlogCategory::class)->findAvailableSortedByName(),
                    'multiple' => true,
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
                'published',
                DateFilter::class,
                array(
                    'label' => 'admin.label.published',
                    'field_type' => DatePickerType::class,
                    'format' => 'd/m/Y',
                ),
                null,
                array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
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
                'tags',
                null,
                [
                    'label' => 'admin.label.blog_tags',
                ],
                EntityType::class,
                array(
                    'class' => BlogCategory::class,
                    'query_builder' => $this->em->getRepository(BlogCategory::class)->findAllQB(),
                )
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
                'published',
                'date',
                [
                    'label' => 'admin.label.published',
                    'format' => 'd/m/Y',
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
                'tags',
                null,
                [
                    'label' => 'admin.label.blog_tags',
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
