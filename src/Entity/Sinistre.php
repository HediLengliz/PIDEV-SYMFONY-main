<?php

namespace App\Entity;

use App\Repository\SinistreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SinistreRepository::class)]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "sinister_type", type: "string")]
/*#[ORM\DiscriminatorMap(["sinister" => "Sinister", "sinisterLife" => "SinisterLife"])]*/
#[ORM\DiscriminatorMap(array(
    "sinisterLife" => "SinisterLife"
))]
class Sinistre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateSinister = null;
    public function __construct()
    {
        $this->dateSinister = new \DateTime();
        $this->statusSinister = 'ongoing';
    }
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter the location.')]
    private ?string $location = null;
    #[ORM\ManyToOne(inversedBy: 'theSinisters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $sinisterUser = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: 'Please enter the amount of the sinister.')]
    private ?float $amountSinister = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Please enter the status of the sinister.')]
    #[Assert\Choice(choices: ["ongoing", "processed", "closed"])]
    private ?string $statusSinister = null;



    public function getId(): ?int
    {
        return $this->id;
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
    public function getAmountSinister(): ?float
    {
        return $this->amountSinister;
    }

    public function setAmountSinister(?float $amountSinister): static
    {
        $this->amountSinister = $amountSinister;

        return $this;
    }

    public function getStatusSinister(): ?string
    {
        return $this->statusSinister;
    }

    public function setStatusSinister(?string $statusSinister): static
    {
        $this->statusSinister = $statusSinister;

        return $this;
    }
}
