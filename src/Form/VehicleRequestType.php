<?php

namespace App\Form;
use App\Entity\User;

use App\Entity\VehicleRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VehicleRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateRequest')
            ->add('typeInsurance', ChoiceType::class, [
                 'choices' => [
                     'Assurance véhicule' => 'vehicule',
                     'Assurance habitat' => 'habitat',
                     'Assurance vie' => 'vie',
                 ],
                 'placeholder' => 'Choisir le type de votre assurance',
             ])
            ->add('Marque', TextType::class, [
                                            'attr' => [
                                                'placeholder' => 'Entrez la marque de votre vehicule',
                                            ],
                                            ])
            ->add('Modele', TextType::class, [
                                          'attr' => [
                                              'placeholder' => 'Entrez le modele de votre vehicule',
                                          ],
                                          ])
            ->add('Fab_year')
            ->add('serial_number', TextType::class, [
                                                 'attr' => [
                                                     'placeholder' => 'Entrez le numéro de série de votre vehicule',
                                                ],
                                                                                           ])
            ->add('matricul_number', TextType::class, [
                                                   'attr' => [
                                                       'placeholder' => 'Entrez la matricule de votre vehicule',
                                                   ],
                                                                                              ])
            ->add('vehicle_price', TextType::class, [
                                                 'attr' => [
                                                     'placeholder' => "Entrez le prix d'achat de votre vehicule.",
                                                 ],
                                                                                            ])
                  ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VehicleRequest::class,
        ]);
    }
}
