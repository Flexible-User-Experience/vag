<?php

namespace App\Admin;

use App\Entity\EventCategory;
use App\Entity\EventCollaborator;
use App\Entity\EventLocation;
use App\Enum\LanguageEnum;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Filter\DateFilter;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class EventActivityAdmin
 */
final class EventActivityAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.event_activity';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'esdeveniment/activitat';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'begin',
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
            ->tab('Activitat')
            ->with('admin.with.activity', ['class' => 'col-md-5'])
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
            ->add(
                'target',
                TextType::class,
                [
                    'label' => 'admin.label.target',
                    'required' => false,
                ]
            )
            ->end()
            ->with('admin.with.relations', ['class' => 'col-md-4'])
            ->add(
                'category',
                EntityType::class,
                [
                    'label' => 'admin.label.category',
                    'class' => EventCategory::class,
                    'query_builder' => $this->em->getRepository(EventCategory::class)->findAvailableSortedByPriorityAndName(),
                ]
            )
            ->add(
                'location',
                EntityType::class,
                [
                    'label' => 'admin.label.location',
                    'class' => EventLocation::class,
                    'query_builder' => $this->em->getRepository(EventLocation::class)->findAllSortedByPlace(),
                ]
            )
            ->add(
                'collaborators',
                EntityType::class,
                [
                    'label' => 'admin.label.collaborators',
                    'class' => EventCollaborator::class,
                    'query_builder' => $this->em->getRepository(EventCollaborator::class)->findAllSortedBySurnameAndName(),
                    'multiple' => true,
                ]
            )
            ->add(
                'language',
                ChoiceType::class,
                [
                    'label' => 'admin.label.language.language',
                    'required' => false,
                    'choices' => LanguageEnum::getStaticChoices(),
                ]
            )
            ->add(
                'isTranslated',
                CheckboxType::class,
                [
                    'label' => 'admin.label.is_translated',
                    'required' => false,
                ]
            )
            ->end()
        ;
        if ($this->formBuilderIsInEditMode()) {
            $formMapper
                ->with('admin.with.images', ['class' => 'col-md-3'])
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
            ->with('admin.with.tickets', ['class' => 'col-md-3'])
            ->add(
                'ticketsAmount',
                NumberType::class,
                [
                    'label' => 'admin.label.tickets_amount',
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'ticketsSold',
                NumberType::class,
                [
                    'label' => 'admin.label.tickets_sold',
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'ticketPrice',
                NumberType::class,
                [
                    'label' => 'admin.label.ticket_price',
                    'required' => false,
                ]
            )
            ->add(
                'eventbriteId',
                TextType::class,
                [
                    'label' => 'admin.label.eventbrite_id',
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
                'begin',
                DateTimePickerType::class,
                [
                    'label' => 'admin.label.begin',
                    'format' => 'd/M/y HH:mm',
                    'required' => true,
                ]
            )
            ->add(
                'end',
                DateTimePickerType::class,
                [
                    'label' => 'admin.label.end',
                    'format' => 'd/M/y HH:mm',
                    'required' => true,
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
            ->add(
                'isAvailable',
                CheckboxType::class,
                [
                    'label' => 'admin.label.is_available',
                    'required' => false,
                ]
            )
            ->end()
            ->end()
            ->tab('Logística')
            ->with('Logística / necessitats', ['class' => 'col-md-5'])
            ->add(
                'field1',
                TextareaType::class,
                [
                    'label' => 'Quin material extra necessita aportar l\'organització del VAG per a realitzar l\'activitat?',
                    'help' => 'Aquesta informació prové de la targeta ACTIVITAT.',
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'rows' => '5',
                        'style' => 'resize:vertical',
                    ],
                ]
            )
            ->add(
                'field2',
                TextareaType::class,
                [
                    'label' => 'Quin material extra necessita aportar l\'organització del VAG per a realitzar l\'activitat?',
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'rows' => '5',
                        'style' => 'resize:vertical',
                    ],
                ]
            )
            ->add(
                'field3',
                TextareaType::class,
                [
                    'label' => 'S\'ha de posar catering? En cas afirmatiu, quin tipus de catering? Qui el proveeix?',
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'rows' => '5',
                        'style' => 'resize:vertical',
                    ],
                ]
            )
            ->add(
                'field4',
                TextareaType::class,
                [
                    'label' => 'S\'ha de repartir algun tipus de merchandising del VAG als assistents o participants? Quin? (llapis, quaderns, samarretes, tasses... tenir en compte que si són samarretes, quines talles?)',
                    'help' => 'Anotar aquesta resposta i adjuntar pressupost a la targeta de PRESSUPOST ACTIVITAT.',
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'rows' => '5',
                        'style' => 'resize:vertical',
                    ],
                ]
            )
            ->add(
                'field5',
                TextareaType::class,
                [
                    'label' => 'Ha d\'haver certificats d\'assistència per als participants? En cas afirmatiu s\'ha de dissenyar i imprimir. Qui ho imprimeix?',
                    'help' => 'Això s\'ha d\'anotar també a la targeta de COMUNICACIÓ i a PRESSUPOST ACTIVITAT.',
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'rows' => '5',
                        'style' => 'resize:vertical',
                    ],
                ]
            )
            ->add(
                'field6',
                TextareaType::class,
                [
                    'label' => 'Imprimir text de consentiment per a la RGPD/LOPD per aconseguir dades dels assistents. Com s\'emmagatzemaran les dades el dia de l\'activitat? S\'ha de crear una base de dades en algun programa? Quin?',
                    'help' => 'Aquestes dades s\'han de pujar a Mailchimp per a fer comunicació a posterior del VAG.',
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'rows' => '5',
                        'style' => 'resize:vertical',
                    ],
                ]
            )
            ->end()
            ->with('admin.with.controls', ['class' => 'col-md-3'])
            ->add(
                'field7',
                CheckboxType::class,
                [
                    'label' => 'Inscripció Eventbrite',
                    'help' => 'S\'ha preparat la inscripció a la plataforma Eventbrite.',
                    'mapped' => false,
                    'required' => false,
                ]
            )
            ->end()
            // Quin material ens cedeixen al lloc on es realitzarà l'activitat? Aquesta informació prové de la targeta ACTIVITAT.
            ->end()
            ->tab('Públic Objectiu')
            ->with('Públic Objectiu', ['class' => 'col-md-5'])
            ->end()
            ->end()
            ->tab('Comunicació')
            ->with('Comunicació', ['class' => 'col-md-5'])
            ->end()
            ->end()
            ->tab('Web')
            ->with('Web', ['class' => 'col-md-5'])
            ->end()
            ->end()
            ->tab('Objectiu')
            ->with('Objectiu', ['class' => 'col-md-5'])
            ->end()
            ->end()
            ->tab('Pressupost' )
            ->with('Pressupost activitat', ['class' => 'col-md-5'])
            ->end()
            ->end()
            ->tab('Calendari')
            ->with('Calendari execució', ['class' => 'col-md-5'])
            ->end()
            ->end()
            ->tab('Pla B')
            ->with('Pla B', ['class' => 'col-md-5'])
            ->end()
            ->end()
            ->tab('Observacions Post-Activitat')
            ->with('Observacions Post-Activitat', ['class' => 'col-md-5'])
            ->end()
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
                'begin',
                DateFilter::class,
                array(
                    'label' => 'admin.label.begin',
                    'field_type' => DateTimePickerType::class,
                    'format' => 'd/m/Y H:i',
                ),
                null,
                array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
                )
            )
            ->add(
                'end',
                DateFilter::class,
                array(
                    'label' => 'admin.label.end',
                    'field_type' => DateTimePickerType::class,
                    'format' => 'd/m/Y H:i',
                ),
                null,
                array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm',
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
                'target',
                null,
                [
                    'label' => 'admin.label.target',
                ]
            )
            ->add(
                'category',
                null,
                [
                    'label' => 'admin.label.category',
                ],
                EntityType::class,
                [
                    'class' => EventCategory::class,
                    'query_builder' => $this->em->getRepository(EventCategory::class)->findAvailableSortedByPriorityAndName(),
                ]
            )
            ->add(
                'location',
                null,
                [
                    'label' => 'admin.label.location',
                ],
                EntityType::class,
                [
                    'class' => EventLocation::class,
                    'query_builder' => $this->em->getRepository(EventLocation::class)->findAllSortedByPlace(),
                ]
            )
            ->add(
                'collaborators',
                null,
                [
                    'label' => 'admin.label.collaborators',
                ],
                EntityType::class,
                [
                    'class' => EventCollaborator::class,
                    'query_builder' => $this->em->getRepository(EventCollaborator::class)->findAllSortedBySurnameAndName(),
                ]
            )
            ->add(
                'language',
                null,
                [
                    'label' => 'admin.label.language.language',
                ],
                ChoiceType::class,
                [
                    'choices' => LanguageEnum::getStaticChoices(),
                ]
            )
            ->add(
                'isTranslated',
                null,
                [
                    'label' => 'admin.label.is_translated',
                ]
            )
            ->add(
                'eventbriteId',
                null,
                [
                    'label' => 'admin.label.eventbrite_id',
                ]
            )
            ->add(
                'showInHomepage',
                null,
                [
                    'label' => 'admin.label.show_in_homepage_short',
                ]
            )
            ->add(
                'isAvailable',
                null,
                [
                    'label' => 'admin.label.is_available',
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
                'begin',
                'date',
                [
                    'label' => 'admin.label.begin',
                    'format' => 'd/m/Y H:i',
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
                'category',
                null,
                [
                    'label' => 'admin.label.category',
                    'editable' => false,
                    'associated_property' => 'name',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'name'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'category')),
                ]
            )
            ->add(
                'location',
                null,
                [
                    'label' => 'admin.label.location',
                    'editable' => false,
                    'associated_property' => 'place',
                    'sortable' => true,
                    'sort_field_mapping' => array('fieldName' => 'place'),
                    'sort_parent_association_mappings' => array(array('fieldName' => 'location')),
                ]
            )
            ->add(
                'eventbriteId',
                null,
                [
                    'label' => 'admin.label.eventbrite_id',
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
                'isAvailable',
                null,
                [
                    'label' => 'admin.label.is_available',
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
