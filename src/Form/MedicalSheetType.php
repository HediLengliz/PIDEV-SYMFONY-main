<?php

namespace App\Form;

use App\Entity\MedicalSheet;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;


class MedicalSheetType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('medicalDiagnosis')
            ->add('treatmentPlan')
            ->add('medicalReports')
            ->add('durationOfIncapacity')
            ->add('procedurePerformed')
            ->add('sickLeaveDuration')
            ->add('hospitalizationPeriod')
            ->add('rehabilitationPeriod')
            ->add('medicalInformation')
            ->add('userCIN', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'cin',
            ])
            ->add('sinisterLife')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MedicalSheet::class,
        ]);
    }

    private function getUserCINChoices(): array
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $cinChoices = [];

        foreach ($users as $user) {
            $cin = $user->getCin();
            $cinChoices[$cin] = $cin;
        }

        return $cinChoices;
    }
}
