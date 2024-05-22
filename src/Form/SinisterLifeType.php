<?php

namespace App\Form;

use App\Entity\SinisterLife;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Valid;
use App\Validator\Constraints\VerifyChanges;

class SinisterLifeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateSinister')
            ->add('location')
            ->add('amountSinister')
            ->add('description')
            ->add('beneficiaryName')
            ->add('sinisterUser')
            /*->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-primary'],
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SinisterLife::class,
            'validation_groups' => ['Default', 'sinister_life'],
        ]);
    }
}
