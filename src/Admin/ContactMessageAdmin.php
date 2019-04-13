<?php

namespace App\Admin;

use App\Enum\GenderEnum;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

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
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.with.collaborator', ['class' => 'col-md-4'])
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'admin.label.name',
                ]
            )
            ->add(
                'surname',
                TextType::class,
                [
                    'label' => 'admin.label.surname',
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
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.with.text', ['class' => 'col-md-4'])
            ->add(
                'shortDescription',
                TextType::class,
                [
                    'label' => 'admin.label.short_description',
                    'required' => false,
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
                'gender',
                ChoiceType::class,
                [
                    'label' => 'admin.label.gender.gender',
                    'choices' => GenderEnum::getStaticChoices(),
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
