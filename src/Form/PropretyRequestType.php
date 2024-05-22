<?php

namespace App\Form;
use App\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\PropretyRequest;

class PropretyRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateRequest')
            ->add('typeInsurance', ChoiceType::class, [
                'choices' => [
                    "--Choisir le type de l'assurance--" => 'choisir le type de la maison',
                    'Assurance véhicule' => 'vehicule',
                    'Assurance habitat' => 'habitat',
                    'Assurance vie' => 'vie',
                ],
            ])
           
            ->add('PropertyForme', ChoiceType::class, [
                'choices' => [
                    'Villa' => 'Villa',
                    'Appartement' => 'Appartement',
                ],
                'placeholder' => "Choisir le type de l'habitat ",
            ])
            ->add('NumberRooms', ChoiceType::class, [
                'choices' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ],
                'placeholder' => "Choisir le nombre des pièces ",
            ])
            ->add('Address', TextType::class, [
                'attr' => [
                    'placeholder' => "Entrez l'adresse de l'habitat...",
                ],
            ])
            ->add('PropertyValue', TextType::class, [
                'attr' => [
                    'placeholder' => "Entrez la valeur de l'habitat...",
                ],
            ])
            ->add('Surface', TextType::class, [
                'attr' => [
                    'placeholder' => "Entrez la surface de l'habitat...",
                ],
            ])
         ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropretyRequest::class,
        ]);
    }
}
