<?php

namespace App\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

/**
 * Class EventLocationAdmin
 */
final class EventLocationAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.event_locations';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'esdeveniment/ubicacio';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'place',
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
            ->with('admin.with.location', ['class' => 'col-md-4'])
            ->add(
                'latitude',
                NumberType::class,
                [
                    'label' => 'admin.label.latitude',
                    'scale' => 14,
                ]
            )
            ->add(
                'longitude',
                NumberType::class,
                [
                    'label' => 'admin.label.longitude',
                    'scale' => 14,
                ]
            )
            ->add(
                'place',
                TextType::class,
                [
                    'label' => 'admin.label.place',
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'label' => 'admin.label.description',
                    'required' => false,
                    'attr' => [
                        'rows' => '5',
                        'style' => 'resize:vertical',
                    ],
                ]
            )
            ->end()
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
            ->with('admin.with.controls', ['class' => 'col-md-4'])
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
                'link',
                UrlType::class,
                [
                    'label' => 'admin.label.link',
                    'required' => false,
                ]
            )
            ->add(
                'tourismMarketResource',
                CheckboxType::class,
                [
                    'label' => 'admin.label.tourism_market_resource',
                    'required' => false,
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
                'place',
                null,
                [
                    'label' => 'admin.label.place',
                ]
            )
            ->add(
                'link',
                null,
                [
                    'label' => 'admin.label.link',
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
                'tourismMarketResource',
                null,
                [
                    'label' => 'admin.label.tourism_market_resource_short',
                ]
            )
            ->add(
                'showInHomepage',
                null,
                [
                    'label' => 'admin.label.show_in_homepage_short',
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
                'place',
                null,
                [
                    'label' => 'admin.label.place',
                    'editable' => true,
                ]
            )
            ->add(
                'link',
                null,
                [
                    'label' => 'admin.label.link',
                    'editable' => true,
                ]
            )
            ->add(
                'tourismMarketResource',
                null,
                [
                    'label' => 'admin.label.tourism_market_resource_short',
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
