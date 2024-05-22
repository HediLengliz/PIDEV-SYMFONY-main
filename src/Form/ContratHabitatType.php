<?php

namespace App\Form;
use App\Entity\PropretyRequest;


use App\Entity\ContratHabitat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ContratHabitatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       $builder
           ->add('Date_debut')
           ->add('Date_fin')
           ->add('Description')
           ->add('MatriculeAgent')
           ->add('Prix')
           ->add('request', EntityType::class, [
               'class' => PropretyRequest::class,
               'choice_label' => 'id',
           ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContratHabitat::class,
        ]);
    }
}



