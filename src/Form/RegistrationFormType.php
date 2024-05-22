<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use VictorPrdh\RecaptchaBundle\Form\ReCaptchaType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('cin')
        ->add('firstName', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your first name.',
                ]),
                new Length([
                    'min' => 2,
                    'max' => 20,
                    'minMessage' => 'Your first name should be at least {{ limit }} characters.',
                    'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters.',
                ]),
            ],
        ])
        ->add('lastName', TextType::class, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter your last name.',
                ]),
                new Length([
                    'min' => 2,
                    'max' => 20,
                    'minMessage' => 'Your last name should be at least {{ limit }} characters.',
                    'maxMessage' => 'Your last name cannot be longer than {{ limit }} characters.',
                ]),
            ],
        ])
        ->add('email')
        ->add('address')
        ->add('phoneNumber')
        ->add('email')
        ->add('captcha',ReCaptchaType::class)

     
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
