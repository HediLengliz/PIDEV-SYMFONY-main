<?php

namespace App\Entity;

use App\Repository\RemorqueurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RemorqueurRepository::class)]
class Remorqueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'veuillez fournir le prenom du remorqueur')]
    private ?string $FirstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'veuillez fournir le nom du remorquer')]
    private ?string $LastName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'veuillez fournir le numéro du remorquer')]

    private ?string $PhoneNumber = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'veuillez fournir la lattitude du remorquer')]

    private ?float $lattitude = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'veuillez fournir longitude du remorquer')]

    private ?float $longuitude = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(string $PhoneNumber): static
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    public function getLattitude(): ?float
    {
        return $this->lattitude;
    }

    public function setLattitude(float $lattitude): static
    {
        $this->lattitude = $lattitude;

        return $this;
    }

    public function getLonguitude(): ?float
    {
        return $this->longuitude;
    }

    public function setLonguitude(float $longuitude): static
    {
        $this->longuitude = $longuitude;

        return $this;
    }
}
