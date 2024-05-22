<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\VehicleRequest;

use App\Entity\ContratVehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContratVehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date_debut')
            ->add('Prix')
            ->add('Date_fin')
            ->add('Description')
            ->add('MatriculeAgent')

           ->add('request', EntityType::class, [
               'class' => VehicleRequest::class,
               'choice_label' => 'id',
           ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContratVehicule::class,
        ]);
    }
}
