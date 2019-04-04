<?php

namespace App\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('admin.with.location', ['class' => 'col-md-4'])
            ->add(
                'place',
                TextType::class,
                [
                    'label' => 'admin.label.place',
                ]
            )
            ->end()
            ->with('admin.with.images', ['class' => 'col-md-4'])
            ->add(
                'imageFile',
                VichImageType::class,
                [
                    'label' => 'admin.label.image',
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
                'place',
                null,
                [
                    'label' => 'admin.label.place',
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
                'place',
                null,
                [
                    'label' => 'admin.label.place',
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
