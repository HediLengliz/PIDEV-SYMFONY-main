<?php

namespace App\Form;

use App\Entity\Prescription;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datePrescription')
            ->add('medications')
            ->add('statusPrescription')
            ->add('additionalNotes')
            ->add('validityDuration')
            ->add('userCIN', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'cin',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prescription::class,
        ]);
    }
}
