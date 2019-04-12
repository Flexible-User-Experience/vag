<?php

namespace App\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

/**
 * Class TeamPartnerAdmin
 */
final class TeamPartnerAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.team_partner';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'equip/patrocinador';

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
            ->with('admin.with.team_partner', ['class' => 'col-md-4'])
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'admin.label.name',
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
                'showInFrontend',
                CheckboxType::class,
                [
                    'label' => 'admin.label.show_in_frontend',
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
                'showInFrontend',
                null,
                [
                    'label' => 'admin.label.show_in_frontend_short',
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
                'name',
                null,
                [
                    'label' => 'admin.label.name',
                    'editable' => true,
                ]
            )
            ->add(
                'showInFrontend',
                null,
                [
                    'label' => 'admin.label.show_in_frontend_short',
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
