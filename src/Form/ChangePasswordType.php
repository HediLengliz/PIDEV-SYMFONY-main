<?php

namespace App\Form;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Current Password',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter a current password.',
                    ]),
                    
                ],
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'New Password',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please enter a new password.',
                    ]),
                    new Assert\Length([
                        'min' => 6,
                        'max' => 20,
                        'minMessage' => 'Your new password should be at least {{ limit }} characters.',
                        'maxMessage' => 'Your new password cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('renewPassword', PasswordType::class, [
                'label' => 'Re-enter New Password',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Please re-enter the new password.',
                    ]),
                    new Assert\Length([
                        'min' => 6,
                        'max' => 20,
                        'minMessage' => 'Your new password should be at least {{ limit }} characters.',
                        'maxMessage' => 'Your new password cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Set your data_class option if needed
        ]);
    }
}
