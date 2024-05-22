<?php

namespace App\Form;

use App\Entity\Rapport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use  Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Sinister;
class RapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('decision', ChoiceType::class, [
                'choices' => [
                    'accépté par la garantie' => 'accépté par la garantie',
                    'non accépté par la garantie' => 'non accépté par la garantie',
                   
                ],
                'placeholder' => 'Sélectionnez une décision', 
                
            ])
       
            ->add('justification', TextareaType::class, [
                'label' => 'Justification',
               
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
        ]);
    }
}
