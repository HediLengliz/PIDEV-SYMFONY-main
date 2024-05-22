<?php

namespace App\Entity;

use App\Repository\ContratVehiculeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContratVehiculeRepository::class)]
class ContratVehicule extends ContratAssurance
{

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'La date du debut est obligatoire')]

    private ?\DateTimeInterface $Date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'La date de la fin est obligatoire')]
    private ?\DateTimeInterface $Date_fin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le champs détail est obligatoire')]

    private ?string $Description = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Votre matricule est obligatoire')]

    private ?string $MatriculeAgent = null;

    #[ORM\Column(length: 20)]
    private ?string $Prix = null;



    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->Date_debut;
    }

    public function setDateDebut(\DateTimeInterface $Date_debut): static
    {
        $this->Date_debut = $Date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->Date_fin;
    }

    public function setDateFin(\DateTimeInterface $Date_fin): static
    {
        $this->Date_fin = $Date_fin;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getMatriculeAgent(): ?string
    {
        return $this->MatriculeAgent;
    }

    public function setMatriculeAgent(string $MatriculeAgent): static
    {
        $this->MatriculeAgent = $MatriculeAgent;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->Prix;
    }

    public function setPrix(string $Prix): static
    {
        $this->Prix = $Prix;

        return $this;
    }
}
