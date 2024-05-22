<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: RapportRepository::class)]
class Rapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'veuillez préciser votre décision')]
    private ?string $decision = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Sinister $SinisterRapport = null;

    #[Assert\NotBlank(message: 'veuillez fournir une justification')]
    #[ORM\Column(length: 255)]
    private ?string $justification = null;

    public function getJustification(): ?string
    {
        return $this->justification;
    }

    public function setJustification(?string $justification): static
    {
        $this->justification = $justification;

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDecision(): ?string
    {
        return $this->decision;
    }

    public function setDecision(string $decision): static
    {
        $this->decision = $decision;

        return $this;
    }

    public function getSinisterRapport(): ?Sinister
    {
        return $this->SinisterRapport;
    }

    public function setSinisterRapport(?Sinister $SinisterRapport): static
    {
        $this->SinisterRapport = $SinisterRapport;

        return $this;
    }
}
