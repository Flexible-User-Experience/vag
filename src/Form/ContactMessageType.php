<?php

namespace App\Form;

use App\Entity\ContactMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactMessageType.
 */
class ContactMessageType extends AbstractType
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
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'frontend.forms.name',
                    ],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'frontend.forms.email',
                    ],
                ]
            )
            ->add(
                'privacy',
                CheckboxType::class,
                [
                    'label' => 'frontend.forms.privacy',
                    'required' => true,
                    'mapped' => false,
                ]
            )
//            ->add(
//                'recaptcha',
//                EWZRecaptchaType::class,
//                array(
//                    'label' => false,
//                    'mapped' => false,
//                    'attr' => array(
//                        'options' => array(
//                            'theme' => 'light',
//                            'type' => 'image',
//                            'size' => 'normal',
//                            'defer' => false,
//                            'async' => false,
//                        ),
//                    ),
//                    'constraints' => array(
//                        new RecaptchaTrue(array(
//                            'message' => 'Error',
//                        )),
//                    ),
//                )
//            )
            ->add(
                'send',
                SubmitType::class,
                [
                    'label' => 'frontend.forms.news',
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
                'data_class' => ContactMessage::class,
            ]
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'contact_message';
    }
}
