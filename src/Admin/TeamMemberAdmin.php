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
 * Class TeamMemberAdmin
 */
final class TeamMemberAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.team_member';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'equip/membre';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'surname',
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
            ->with('admin.with.team_member', ['class' => 'col-md-4'])
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
                    'required' => false,
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
                'job',
                TextType::class,
                [
                    'label' => 'admin.label.job',
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
            ->end();
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
                'surname',
                null,
                [
                    'label' => 'admin.label.surname',
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
                'phone',
                null,
                [
                    'label' => 'admin.label.phone',
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
                'surname',
                null,
                [
                    'label' => 'admin.label.surname',
                    'editable' => true,
                ]
            )
            ->add(
                'email',
                null,
                [
                    'label' => 'admin.label.email',
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
