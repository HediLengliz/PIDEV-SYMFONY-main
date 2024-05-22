<?php

namespace App\Entity;

use App\Repository\SinisterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SinisterRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(array(
    "sinistreVehicule" => "SinisterVehicle",
    "sinistreProperty" => "SinisterProperty"
))]
abstract class Sinister
{
    public function __toString(): string
    {
        // Customize this method based on how you want to represent Sinister as a string
        return $this->getId() ? $this->getId().' - '.$this->getLocation().' - '.$this->getDateSinister()->format('Y-m-d') : 'New Sinister';
    }
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: "La date ne doit pas être vide.")]
    private ?\DateTimeInterface $dateSinister = null;
    

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'veuillez sélectionner la localisation')]
    private ?string $location = null;

    #[ORM\ManyToOne(inversedBy: 'sinisters')]
    private ?User $sinisterUser = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status_sinister = 'en_cours';



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSinister(): ?\DateTimeInterface
    {
        return $this->dateSinister;
    }
    

    public function setDateSinister(\DateTimeInterface $dateSinister): static
    {
        $this->dateSinister = $dateSinister;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getSinisterUser(): ?User
    {
        return $this->sinisterUser;
    }

    public function setSinisterUser(?User $sinisterUser): static
    {
        $this->sinisterUser = $sinisterUser;

        return $this;
    }

   

    public function getStatusSinister(): ?string
    {
        return $this->status_sinister;
    }

    public function setStatusSinister(?string $status_sinister): static
    {
        $this->status_sinister = $status_sinister;

        return $this;
    }

  
}
