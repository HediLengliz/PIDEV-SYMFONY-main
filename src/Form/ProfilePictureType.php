<?php
// src/Form/ProfilePictureType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ProfilePictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFileName', FileType::class, [
                'required' => false,
                'mapped' => false, // This field is not mapped to any entity property
                'constraints'=>[
                    new Image(['maxSize'=>'5000k'])
                ],
                'attr' => [
                    'id' => 'profile_picture',
                    'style' => 'display:none;'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Set your form data_class or remove if not necessary
            'data_class' => null,
        ]);
    }
}
