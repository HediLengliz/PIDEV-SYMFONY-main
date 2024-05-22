<?php

namespace App\Entity;

use App\Repository\PrescriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrescriptionRepository::class)]
class Prescription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private $datePrescription ;

    public function __construct()
    {
        $this->datePrescription = new \DateTime();
    }
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Please enter the status of the medications needed.')]
    private ?string $medications = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Please enter the status of the Prescription.')]
    #[Assert\Choice(choices: ["processed", "unprocessed"])]
    private ?string $statusPrescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $additionalNotes = null;

    #[ORM\Column(nullable: true)]
    private ?int $validityDuration = null;

    #[ORM\ManyToOne(inversedBy: 'prescriptionUser')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userCIN = null;

    public function getdatePrescription(): ?\DateTimeInterface
    {
        return $this->datePrescription;
    }

    public function setdatePrescription(\DateTimeInterface $datePrescription): static
    {
        $this->datePrescription = $datePrescription;

        return $this;
    }


    public function getMedications(): ?string
    {
        return $this->medications;
    }

    public function setMedications(string $medications): static
    {
        $this->medications = $medications;

        return $this;
    }

    public function getStatusPrescription(): ?string
    {
        return $this->statusPrescription;
    }

    public function setStatusPrescription(string $statusPrescription): static
    {
        $this->statusPrescription = $statusPrescription;

        return $this;
    }

    public function getAdditionalNotes(): ?string
    {
        return $this->additionalNotes;
    }

    public function setAdditionalNotes(?string $additionalNotes): static
    {
        $this->additionalNotes = $additionalNotes;

        return $this;
    }

    public function getValidityDuration(): ?int
    {
        return $this->validityDuration;
    }

    public function setValidityDuration(?int $validityDuration): static
    {
        $this->validityDuration = $validityDuration;

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
