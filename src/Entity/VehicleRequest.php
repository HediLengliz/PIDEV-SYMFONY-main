<?php

namespace App\Entity;

use App\Repository\VehicleRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Util\ClassUtils;
#[ORM\Entity(repositoryClass: VehicleRequestRepository::class)]
class VehicleRequest extends InsuranceRequest
{
    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Veuillez entrer la marque de votre vehicule')]

    private ?string $Marque = null;

    #[ORM\Column(length: 20)]
   #[Assert\NotBlank(message: 'Veuillez entrer le modele de votre vehicule.')]

    private ?string $Modele = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'Veuillez entrer la date de fabrication de votre vehicule.')]

    private ?\DateTimeInterface $Fab_year = null;

    #[ORM\Column(length: 20)]
       #[Assert\NotBlank(message: 'Veuillez entrer le numéro de serie de votre vehicule.')]
       #[Assert\Range(
           min: 1,
           max: 245,
           notInRangeMessage: 'Le numéro de série doit être compris entre {{ min }} et {{ max }}.'
       )]

    private ?string $serial_number = null;

    #[ORM\Column(length: 20)]
    #[Assert\Regex(
        pattern: '/^\d{1,3} TUN \d{1,4}$/',
        message: 'Le format de l\'immatriculation doit être : [Nombre entre 1 et 254] TUN [Nombre entre 1 et 9999].'
    )]
       #[Assert\NotBlank(message: "Veuillez entrer l'immatriculation de votre vehicule.")]

    private ?string $matricul_number = null;

    #[ORM\Column(length: 20)]
       #[Assert\NotBlank(message: 'Veuillez entrer la valeur de votre vehicule')]

    private ?string $vehicle_price = null;

    public function getMarque(): ?string
    {
        return $this->Marque;
    }

    public function setMarque(string $Marque): static
    {
        $this->Marque = $Marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->Modele;
    }

    public function setModele(string $Modele): static
    {
        $this->Modele = $Modele;

        return $this;
    }

    public function getFabYear(): ?\DateTimeInterface
    {
        return $this->Fab_year;
    }

    public function setFabYear(\DateTimeInterface $Fab_year): static
    {
        $this->Fab_year = $Fab_year;

        return $this;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serial_number;
    }

    public function setSerialNumber(string $serial_number): static
    {
        $this->serial_number = $serial_number;

        return $this;
    }

    public function getMatriculNumber(): ?string
    {
        return $this->matricul_number;
    }

    public function setMatriculNumber(string $matricul_number): static
    {
        $this->matricul_number = $matricul_number;

        return $this;
    }

    public function getVehiclePrice(): ?string
    {
        return $this->vehicle_price;
    }

    public function setVehiclePrice(string $vehicle_price): static
    {
        $this->vehicle_price = $vehicle_price;

        return $this;
    }
}
