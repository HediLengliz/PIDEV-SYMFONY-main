<?php

namespace App\Entity;

use App\Repository\PropretyRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: PropretyRequestRepository::class)]
class PropretyRequest extends InsuranceRequest
{
    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Veuillez choisir le nombre des piéces de votre habitat')]

    private ?string $PropertyForme = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: 'Veuillez choisir le nombre des piéces de votre habitat')]

    private ?string $NumberRooms = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Veuillez entrer votre adresse.')]

    private ?string $Address = null;

    #[Assert\NotBlank (message:"Veuillez entrer la valeur de l'habitat")]
    #[ORM\Column(length: 20)]
    private ?string $PropertyValue = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Veuillez entrer la surface de l'habitat ")]

    private ?string $Surface = null;

    public function getPropertyForme(): ?string
    {
        return $this->PropertyForme;
    }

    public function setPropertyForme(string $PropertyForme): static
    {
        $this->PropertyForme = $PropertyForme;

        return $this;
    }

    public function getNumberRooms(): ?string
    {
        return $this->NumberRooms;
    }

    public function setNumberRooms(string $NumberRooms): static
    {
        $this->NumberRooms = $NumberRooms;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getPropertyValue(): ?string
    {
        return $this->PropertyValue;
    }

    public function setPropertyValue(string $PropertyValue): static
    {
        $this->PropertyValue = $PropertyValue;

        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->Surface;
    }

    public function setSurface(string $Surface): static
    {
        $this->Surface = $Surface;

        return $this;
    }
}
