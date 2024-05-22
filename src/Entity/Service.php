<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert; 

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap(array(
    "serviceAuto" => "ServiceAuto",
    "serviceLife" => "ServiceLife",
    "serviceProperty" => "ServiceProperty"
))]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message:"name is required")]
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    
    #[Assert\NotNull(message:"price can t be null")]
    #[ORM\Column]
    private ?float $price = null;


    #[ORM\ManyToOne(inversedBy: 'services')]
    private ?Question $question = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }
    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }
}
