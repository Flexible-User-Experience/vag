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
 * Class ContactMessageAdmin
 */
final class ContactMessageAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.contact_message';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'comunicacio/missatge-contacte';

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
            ->with('admin.with.contact_message', ['class' => 'col-md-4'])
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
            ->with('admin.with.text', ['class' => 'col-md-4'])
            ->add(
                'createdString',
                TextType::class,
                [
                    'label' => 'admin.label.created',
                ]
            )
            ->add(
                'message',
                TextType::class,
                [
                    'label' => 'admin.label.message',
                ]
            )
            ->add(
                'answeredString',
                TextType::class,
                [
                    'label' => 'admin.label.answered',
                ]
            )
            ->add(
                'answer',
                TextType::class,
                [
                    'label' => 'admin.label.answer',
                ]
            )
            ->end()
            ->with('admin.with.controls', ['class' => 'col-md-4'])
            ->add(
                'legalTermsHasBeenAccepted',
                Type::BOOLEAN,
                [
                    'label' => 'admin.label.legal_terms_has_been_accepted',
                ]
            )
            ->add(
                'hasBeenReaded',
                Type::BOOLEAN,
                [
                    'label' => 'admin.label.has_been_readed',
                ]
            )
            ->add(
                'hasBeenAnswered',
                Type::BOOLEAN,
                [
                    'label' => 'admin.label.has_been_answered',
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
                'legalTermsHasBeenAccepted',
                null,
                [
                    'label' => 'admin.label.legal_terms_has_been_accepted_short',
                ]
            )
            ->add(
                'hasBeenReaded',
                null,
                [
                    'label' => 'admin.label.has_been_readed_short',
                ]
            )
            ->add(
                'hasBeenAnswered',
                null,
                [
                    'label' => 'admin.label.has_been_answered_short',
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
                'legalTermsHasBeenAccepted',
                null,
                [
                    'label' => 'admin.label.legal_terms_has_been_accepted_short',
                    'editable' => false,
                ]
            )
            ->add(
                'hasBeenReaded',
                null,
                [
                    'label' => 'admin.label.has_been_readed_short',
                    'editable' => false,
                ]
            )
            ->add(
                'hasBeenAnswered',
                null,
                [
                    'label' => 'admin.label.has_been_answered_short',
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
