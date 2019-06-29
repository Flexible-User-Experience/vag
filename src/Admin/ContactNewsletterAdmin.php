<?php

namespace App\Admin;

use Doctrine\DBAL\Types\Type;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ContactNewsletterAdmin
 */
final class ContactNewsletterAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.contact_newsletter';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'comunicacio/newsletter-contacte';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'created',
        '_sort_order' => 'DESC',
    );

    /**
     * Methods.
     */

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('edit')
            ->remove('batch')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('admin.with.contact_newsletter', ['class' => 'col-md-4'])
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'admin.label.name',
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
            ->with('admin.with.controls', ['class' => 'col-md-4'])
            ->add(
                'isAvailable',
                Type::BOOLEAN,
                [
                    'label' => 'admin.label.is_available',
                    'required' => false,
                ]
            )
            ->add(
                'legalTermsHasBeenAccepted',
                Type::BOOLEAN,
                [
                    'label' => 'admin.label.legal_terms_has_been_accepted',
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
                'created',
                null,
                [
                    'label' => 'admin.label.created',
                ]
            )
            ->add(
                'name',
                null,
                [
                    'label' => 'admin.label.name',
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
                'isAvailable',
                null,
                [
                    'label' => 'admin.label.is_available',
                ]
            )
            ->add(
                'legalTermsHasBeenAccepted',
                null,
                [
                    'label' => 'admin.label.legal_terms_has_been_accepted_short',
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
                'created',
                null,
                [
                    'label' => 'admin.label.created',
                    'format' => 'd/m/Y H:i',
                    'editable' => false,
                ]
            )
            ->add(
                'name',
                null,
                [
                    'label' => 'admin.label.name',
                    'editable' => false,
                ]
            )
            ->add(
                'email',
                null,
                [
                    'label' => 'admin.label.email',
                    'editable' => false,
                ]
            )
            ->add(
                'isAvailable',
                null,
                [
                    'label' => 'admin.label.is_available',
                    'editable' => false,
                ]
            )
            ->add(
                'legalTermsHasBeenAccepted',
                null,
                [
                    'label' => 'admin.label.legal_terms_has_been_accepted_short',
                    'editable' => false,
                ]
            )
            ->add(
                '_action',
                null,
                [
                    'label' => 'admin.label.actions',
                    'actions' => [
                        'show' => [],
                        'delete' => [],
                    ],
                ]
            )
        ;
    }
}
