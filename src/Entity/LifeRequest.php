<?php

namespace App\Entity;

use App\Repository\LifeRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LifeRequestRepository::class)]
class LifeRequest extends InsuranceRequest
{
   #[ORM\Column(length: 20)]
   #[Assert\NotBlank(message: 'Veuillez entrer votre âge.')]
   #[Assert\Length(
       min: 2,
       max: 3, // Assuming age is a number with at most 3 digits
       minMessage: 'L\'âge doit comporter au moins {{ limit }} caractères.',
       maxMessage: 'L\'âge ne peut pas dépasser {{ limit }} caractères.'
   )]
   #[Assert\GreaterThan(
       value: 18,
       message: 'L\'âge doit être supérieur à 18 ans.'
   )]

    private ?string $Age = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Veuillez mentionner si vous avez une maladie chronique.')]

    private ?string $chron_disease = null;

   #[Assert\NotBlank(message: 'Veuillez mentionner si vous avez affectué une operation.')]

    #[ORM\Column(length: 50)]
    private ?string $surgery = null;

   #[Assert\NotBlank(message: 'Veuillez mentionner votre etat civil.')]
    #[ORM\Column(length: 20)]
    private ?string $civil_status = null;


    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'Veuillez mentionner votre profession.')]

    private ?string $occupation = null;

    #[ORM\Column(length: 100, nullable: true)]

    private ?string $chron_disease_description = null;

    public function getAge(): ?string
    {
        return $this->Age;
    }

    public function setAge(string $Age): static
    {
        $this->Age = $Age;

        return $this;
    }

    public function getChronDisease(): ?string
    {
        return $this->chron_disease;
    }

    public function setChronDisease(string $chron_disease): static
    {
        $this->chron_disease = $chron_disease;

        return $this;
    }

    public function getSurgery(): ?string
    {
        return $this->surgery;
    }

    public function setSurgery(string $surgery): static
    {
        $this->surgery = $surgery;

        return $this;
    }

    public function getCivilStatus(): ?string
    {
        return $this->civil_status;
    }

    public function setCivilStatus(string $civil_status): static
    {
        $this->civil_status = $civil_status;

        return $this;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    public function setOccupation(string $occupation): static
    {
        $this->occupation = $occupation;

        return $this;
    }

    public function getChronDiseaseDescription(): ?string
    {
        return $this->chron_disease_description;
    }

    public function setChronDiseaseDescription(?string $chron_disease_description): static
    {
        $this->chron_disease_description = $chron_disease_description;

        return $this;
    }
}
