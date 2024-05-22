<?php

namespace App\Entity;

use App\Repository\MedicalSheetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedicalSheetRepository::class)]
class MedicalSheet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Please enter your Medical Diagnosis.')]
    private ?string $medicalDiagnosis = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $treatmentPlan = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $medicalReports = null;

    #[ORM\Column(nullable: true)]
    private ?int $durationOfIncapacity = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $procedurePerformed = null;

    #[ORM\Column(nullable: true)]
    private ?int $sickLeaveDuration = null;

    #[ORM\Column(nullable: true)]
    private ?int $hospitalizationPeriod = null;

    #[ORM\Column(nullable: true)]
    private ?int $rehabilitationPeriod = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $medicalInformation = null;

    #[ORM\ManyToOne(inversedBy: 'medicalSheet')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SinisterLife $sinisterLife = null;

    #[ORM\ManyToOne(inversedBy: 'medicalsheetUser')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userCIN = null;




    public function getId(): ?int
    {
        return $this->id;
    }


    public function getMedicalDiagnosis(): ?string
    {
        return $this->medicalDiagnosis;
    }

    public function setMedicalDiagnosis(string $medicalDiagnosis): static
    {
        $this->medicalDiagnosis = $medicalDiagnosis;

        return $this;
    }

    public function getTreatmentPlan(): ?string
    {
        return $this->treatmentPlan;
    }

    public function setTreatmentPlan(?string $treatmentPlan): static
    {
        $this->treatmentPlan = $treatmentPlan;

        return $this;
    }

    public function getMedicalReports(): ?string
    {
        return $this->medicalReports;
    }

    public function setMedicalReports(?string $medicalReports): static
    {
        $this->medicalReports = $medicalReports;

        return $this;
    }

    public function getDurationOfIncapacity(): ?int
    {
        return $this->durationOfIncapacity;
    }

    public function setDurationOfIncapacity(?int $durationOfIncapacity): static
    {
        $this->durationOfIncapacity = $durationOfIncapacity;

        return $this;
    }

    public function getProcedurePerformed(): ?string
    {
        return $this->procedurePerformed;
    }

    public function setProcedurePerformed(?string $procedurePerformed): static
    {
        $this->procedurePerformed = $procedurePerformed;

        return $this;
    }

    public function getSickLeaveDuration(): ?int
    {
        return $this->sickLeaveDuration;
    }

    public function setSickLeaveDuration(?int $sickLeaveDuration): static
    {
        $this->sickLeaveDuration = $sickLeaveDuration;

        return $this;
    }

    public function getHospitalizationPeriod(): ?int
    {
        return $this->hospitalizationPeriod;
    }

    public function setHospitalizationPeriod(?int $hospitalizationPeriod): static
    {
        $this->hospitalizationPeriod = $hospitalizationPeriod;

        return $this;
    }

    public function getRehabilitationPeriod(): ?int
    {
        return $this->rehabilitationPeriod;
    }

    public function setRehabilitationPeriod(?int $rehabilitationPeriod): static
    {
        $this->rehabilitationPeriod = $rehabilitationPeriod;

        return $this;
    }

    public function getMedicalInformation(): ?string
    {
        return $this->medicalInformation;
    }

    public function setMedicalInformation(?string $medicalInformation): static
    {
        $this->medicalInformation = $medicalInformation;

        return $this;
    }

    public function getSinisterLife(): ?SinisterLife
    {
        return $this->sinisterLife;
    }

    public function setSinisterLife(?SinisterLife $sinisterLife): static
    {
        $this->sinisterLife = $sinisterLife;

        return $this;
    }


    public function getUserCIN(): ?User
    {
        return $this->userCIN;
    }

    public function setUserCIN(?User $userCIN): static
    {
        $this->userCIN = $userCIN;

        return $this;
    }

}
