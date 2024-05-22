<?php

namespace App\Form;

use App\Entity\Remorqueur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemorqueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName')
            ->add('LastName')
            ->add('PhoneNumber')
            ->add('lattitude')
            ->add('longuitude')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Remorqueur::class,
        ]);
    }
}
