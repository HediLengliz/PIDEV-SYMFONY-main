<?php

namespace App\Entity;

use App\Repository\SinisterLifeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SinisterLifeRepository::class)]
class SinisterLife extends Sinistre
{
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 20)]
    private ?string $beneficiaryName = null;

    #[ORM\OneToMany(targetEntity: MedicalSheet::class, mappedBy: 'sinisterLife', orphanRemoval: true)]
    private Collection $medicalSheet;

    private array $originalValues = [];
    public function __construct()
    {
        parent::__construct();
        $this->medicalSheet = new ArrayCollection();
        $this->originalValues = [
            'location' => $this->getLocation(),
            'amountSinister' => $this->getAmountSinister(),
            'statusSinister' => $this->getstatusSinister(),
            'description' => $this->getdescription(),
            'beneficiaryName' => $this->getbeneficiaryName(),
        ];
    }
    public function getOriginalValues(): array
    {
        return $this->originalValues;
    }

    public function __toString(): string
    {
        return $this->description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getBeneficiaryName(): ?string
    {
        return $this->beneficiaryName;
    }

    public function setBeneficiaryName(string $beneficiaryName): static
    {
        $this->beneficiaryName = $beneficiaryName;

        return $this;
    }

    /**
     * @return Collection<int, MedicalSheet>
     */
    public function getMedicalSheet(): Collection
    {
        return $this->medicalSheet;
    }

    public function addMedicalSheet(MedicalSheet $medicalSheet): static
    {
        if (!$this->medicalSheet->contains($medicalSheet)) {
            $this->medicalSheet->add($medicalSheet);
            $medicalSheet->setSinisterLife($this);
        }

        return $this;
    }

    public function removeMedicalSheet(MedicalSheet $medicalSheet): static
    {
        if ($this->medicalSheet->removeElement($medicalSheet)) {
            // set the owning side to null (unless already changed)
            if ($medicalSheet->getSinisterLife() === $this) {
                $medicalSheet->setSinisterLife(null);
            }
        }

        return $this;
    }
}
