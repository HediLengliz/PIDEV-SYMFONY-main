<?php

namespace App\Form;

use App\Entity\SinisterVehicle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Util\ClassUtils;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
#[Vich\Uploadable]
class SinisterVehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Step1: Information about the sinister
            ->add('dateSinister')
            ->add('location')

            // Step2: Information about Vehicle A
            ->add('Nom_Conducteur_A')
            ->add('Prenom_Conducteur_A')
            ->add('Adresse_conducteurA')
            ->add('num_permisA')
            ->add('delivre_A')
            ->add('num_contratA')
            ->add('Marque_VehiculeA')
            ->add('ImmatriculationA')

            // Step3: Information about Vehicle B
            ->add('Nom_Conducteur_B')
            ->add('Prenom_Conducteur_B')
            ->add('Adresse_conducteurB')
            ->add('num_permisB')
            ->add('delivre_B')
            ->add('num_contratB')
            ->add('Marque_VehiculeB')
            ->add('ImmatriculationB')
            ->add('BvehiculeAssurePar')
            ->add('agence')
            ->add('imageFile', VichFileType::class, [
                'label' => 'Image de laccident',
                'attr' => ['class' => 'form_label mt-4'],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SinisterVehicle::class,
        ]);
    }
}
