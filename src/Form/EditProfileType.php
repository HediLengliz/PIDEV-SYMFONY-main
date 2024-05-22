<?php

namespace App\Form;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormError;

use App\Entity\User;
// EditProfileType.php



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cin', TextType::class)
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('address')
            ->add('phoneNumber')
            ->addEventListener(FormEvents::SUBMIT, [$this, 'onSubmit']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function onSubmit(FormEvent $event): void
    {
        $user = $event->getData();
        // Check for null values and handle them accordingly
        if ($user->getCin() === null || $user->getFirstName() === null) {
            $event->getForm()->addError(new FormError('All fields are required.'));
        }
    }
}
