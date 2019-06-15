<?php

namespace App\Form;

use App\Entity\ContactNewsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactNewsletterType.
 */
class ContactNewsletterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => null,
                    'attr' => [
                        'placeholder' => 'admin.label.name',
                        'class' => 'form-control form-control-sm mb-2',
                    ],
                    'required' => true,
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => null,
                    'attr' => [
                        'placeholder' => 'admin.label.email',
                        'class' => 'form-control form-control-sm mb-2',
                    ],
                    'required' => true,
                ]
            )
            ->add(
                'privacy',
                CheckboxType::class,
                [
                    'label' => 'admin.label.legal_terms_has_been_accepted',
                    'attr' => [
                        'class' => 'text-white',
                    ],
                    'required' => true,
                    'mapped' => false,
                ]
            )
            ->add(
                'send',
                SubmitType::class,
                [
                    'label' => 'admin.actions.subscribe',
                    'attr' => [
                        'class' => 'btn btn-primary btn-sm',
                    ],
                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ContactNewsletter::class,
            ]
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'contact_newsletter';
    }
}
