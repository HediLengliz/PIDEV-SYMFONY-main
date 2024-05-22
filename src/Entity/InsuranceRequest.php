<?php

namespace App\Entity;

use App\Repository\InsuranceRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InsuranceRequestRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(array(
    "LifeRequest" => "LifeRequest",
    "VehicleRequest" => "VehicleRequest",
    "PropretyRequest" => "PropretyRequest"
))]
class InsuranceRequest

{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateRequest = null;

    #[ORM\Column(length: 20)]

    private ?string $typeInsurance = null;


     #[ORM\Column(length: 255, nullable: true)]
     private ?string $status = 'en_cours';

    #[ORM\ManyToOne(inversedBy: 'insuranceRequests')]

    private ?User $requestUser = null;

    #[ORM\ManyToOne(inversedBy: 'requests')]
    private ?User $user = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRequest(): ?\DateTimeInterface
    {
        return $this->dateRequest;
    }

    public function setDateRequest(\DateTimeInterface $dateRequest): static
    {
        $this->dateRequest = $dateRequest;

        return $this;
    }

    public function getTypeInsurance(): ?string
    {
        return $this->typeInsurance;
    }

    public function setTypeInsurance(string $typeInsurance): static
    {
        $this->typeInsurance = $typeInsurance;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getRequestUser(): ?User
    {
        return $this->requestUser;
    }

    public function setRequestUser(?User $requestUser): static
    {
        $this->requestUser = $requestUser;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }


}
