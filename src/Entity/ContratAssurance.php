<?php

namespace App\Entity;

use App\Repository\ContratAssuranceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratAssuranceRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(array(
    "ContratHabitat" => "ContratHabitat",
    "ContratVie" => "ContratVie",
    "ContratVehicule" => "ContratVehicule"
))]
class ContratAssurance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?InsuranceRequest $request = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequest(): ?InsuranceRequest
    {
        return $this->request;
    }

    public function setRequest(?InsuranceRequest $request): static
    {
        $this->request = $request;

        return $this;
    }


}
