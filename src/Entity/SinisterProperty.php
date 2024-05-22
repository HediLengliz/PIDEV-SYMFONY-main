<?php

namespace App\Entity;

use App\Repository\SinisterPropertyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: SinisterPropertyRepository::class)]
class SinisterProperty extends Sinister
{


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'veuillez sélectionner le type de dégat')]
    private ?string $type_degat = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'veuillez introduire la description des décats survenues')]
    private ?string $description_degat = null;


    public function getTypeDegat(): ?string
    {
        return $this->type_degat;
    }

    public function setTypeDegat(string $type_degat): static
    {
        $this->type_degat = $type_degat;

        return $this;
    }

    public function getDescriptionDegat(): ?string
    {
        return $this->description_degat;
    }

    public function setDescriptionDegat(string $description_degat): static
    {
        $this->description_degat = $description_degat;

        return $this;
    }
}
