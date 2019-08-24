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
                        'placeholder' => 'front.form.label.name',
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
                        'placeholder' => 'front.form.label.email',
                        'class' => 'form-control form-control-sm mb-2',
                    ],
                    'required' => true,
                ]
            )
            ->add(
                'send',
                SubmitType::class,
                [
                    'label' => 'front.form.label.subscribe',
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
                'allow_extra_fields' => true,
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
