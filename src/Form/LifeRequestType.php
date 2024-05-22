<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\LifeRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class LifeRequestType extends AbstractType
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
               'constraints' => [
                   new Assert\NotBlank([
                       'message' => 'Etat de la demande est obligatoire.',
                   ]),
               ],
           ])
            // ->add('status', null, [
            //                 'constraints' => [
            //                     new Assert\NotBlank([
            //                         'message' => 'Etat de la demande est obligatoire.',
            //                     ]),
            //                 ],
            //             ])
            ->add('Age', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez votre âge...',
                ],
            ])
            ->add('chron_disease', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('chron_disease_description', TextType::class, [
                'label' => 'Description de la maladie chronique',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Entrez la description de la maladie chronique ici...',
                ],
            ])
            ->add('surgery', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('civil_status', ChoiceType::class, [
                'choices' => [
                    'Célibataire' => 'Célibataire',
                    'Marié(e)' => 'Marié(e)',
                ],
                'placeholder' => 'Choisir votre état civil',
                'required' => true,
            ])
            ->add('occupation', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez votre profession...',
                ],
            ])
            // ->add('requestUser', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ]);
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LifeRequest::class,
        ]);
    }
}
