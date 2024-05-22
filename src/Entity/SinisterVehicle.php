<?php

namespace App\Entity;

use App\Repository\SinisterVehicleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Util\ClassUtils;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SinisterVehicleRepository::class)]
#[Vich\Uploadable]
class SinisterVehicle extends Sinister
{
    
    #[Vich\UploadableField(mapping: 'sinister_vehicle_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;
    


    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

        
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom du conducteur A ne doit pas être vide.')]
    private ?string $Nom_Conducteur_A = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom du conducteur B ne doit pas être vide.')]
    private ?string $Nom_Conducteur_B = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le prénom du conducteur B ne doit pas être vide.')]
    private ?string $Prenom_Conducteur_B = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le prénom du conducteur A ne doit pas être vide.')]
    private ?string $Prenom_Conducteur_A = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'adresse du conducteur A ne doit pas être vide.')]
    private ?string $Adresse_conducteurA = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'adresse du conducteur B ne doit pas être vide.')]
    private ?string $Adresse_conducteurB = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le numéro de permis A ne doit pas être vide.')]
    private ?string $num_permisA = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le numéro de permis B ne doit pas être vide.')]
    private ?string $num_permisB = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'La date de délivrance A ne doit pas être vide.')]
    private ?\DateTimeInterface $delivre_A = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'La date de délivrance B ne doit pas être vide.')]
    private ?\DateTimeInterface $delivre_B = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le numéro de contrat A ne doit pas être vide.')]
    private ?string $num_contratA = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le numéro de contrat B ne doit pas être vide.')]
    private ?string $num_contratB = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La marque du véhicule A ne doit pas être vide.')]
    private ?string $Marque_VehiculeA = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La marque du véhicule B ne doit pas être vide.')]
    private ?string $Marque_VehiculeB = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'immatriculation A ne doit pas être vide.')]
    private ?string $ImmatriculationA = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'immatriculation B ne doit pas être vide.')]
    private ?string $ImmatriculationB = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le véhicule assuré par ne doit pas être vide.')]
    private ?string $BvehiculeAssurePar = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'agence ne doit pas être vide.')]
    private ?string $agence = null;



 



   
    public function getNomConducteurA(): ?string
    {
        return $this->Nom_Conducteur_A;
    }

    public function setNomConducteurA(string $Nom_Conducteur_A): static
    {
        $this->Nom_Conducteur_A = $Nom_Conducteur_A;

        return $this;
    }

    public function getNomConducteurB(): ?string
    {
        return $this->Nom_Conducteur_B;
    }

    public function setNomConducteurB(string $Nom_Conducteur_B): static
    {
        $this->Nom_Conducteur_B = $Nom_Conducteur_B;

        return $this;
    }

    public function getPrenomConducteurB(): ?string
    {
        return $this->Prenom_Conducteur_B;
    }

    public function setPrenomConducteurB(string $Prenom_Conducteur_B): static
    {
        $this->Prenom_Conducteur_B = $Prenom_Conducteur_B;

        return $this;
    }

    public function getPrenomConducteurA(): ?string
    {
        return $this->Prenom_Conducteur_A;
    }

    public function setPrenomConducteurA(string $Prenom_Conducteur_A): static
    {
        $this->Prenom_Conducteur_A = $Prenom_Conducteur_A;

        return $this;
    }

    public function getAdresseConducteurA(): ?string
    {
        return $this->Adresse_conducteurA;
    }

    public function setAdresseConducteurA(string $Adresse_conducteurA): static
    {
        $this->Adresse_conducteurA = $Adresse_conducteurA;

        return $this;
    }

    public function getAdresseConducteurB(): ?string
    {
        return $this->Adresse_conducteurB;
    }

    public function setAdresseConducteurB(string $Adresse_conducteurB): static
    {
        $this->Adresse_conducteurB = $Adresse_conducteurB;

        return $this;
    }
    public function getNumPermisA(): ?string
    {
        return $this->num_permisA;
    }

    public function setNumPermisA(string $num_permisA): static
    {
        $this->num_permisA = $num_permisA;

        return $this;
    }

    public function getNumPermisB(): ?string
    {
        return $this->num_permisB;
    }

    public function setNumPermisB(string $num_permisB): static
    {
        $this->num_permisB = $num_permisB;

        return $this;
    }

    public function getDelivreA(): ?\DateTimeInterface
    {
        return $this->delivre_A;
    }

    public function setDelivreA(\DateTimeInterface $delivre_A): static
    {
        $this->delivre_A = $delivre_A;

        return $this;
    }

    public function getDelivreB(): ?\DateTimeInterface
    {
        return $this->delivre_B;
    }

    public function setDelivreB(\DateTimeInterface $delivre_B): static
    {
        $this->delivre_B = $delivre_B;

        return $this;
    }

    public function getNumContratA(): ?string
    {
        return $this->num_contratA;
    }

    public function setNumContratA(string $num_contratA): static
    {
        $this->num_contratA = $num_contratA;

        return $this;
    }

    public function getNumContratB(): ?string
    {
        return $this->num_contratB;
    }

    public function setNumContratB(string $num_contratB): static
    {
        $this->num_contratB = $num_contratB;

        return $this;
    }

    public function getMarqueVehiculeA(): ?string
    {
        return $this->Marque_VehiculeA;
    }

    public function setMarqueVehiculeA(string $Marque_VehiculeA): static
    {
        $this->Marque_VehiculeA = $Marque_VehiculeA;

        return $this;
    }

    public function getMarqueVehiculeB(): ?string
    {
        return $this->Marque_VehiculeB;
    }

    public function setMarqueVehiculeB(string $Marque_VehiculeB): static
    {
        $this->Marque_VehiculeB = $Marque_VehiculeB;

        return $this;
    }

    public function getImmatriculationA(): ?string
    {
        return $this->ImmatriculationA;
    }

    public function setImmatriculationA(string $ImmatriculationA): static
    {
        $this->ImmatriculationA = $ImmatriculationA;

        return $this;
    }

    public function getImmatriculationB(): ?string
    {
        return $this->ImmatriculationB;
    }

    public function setImmatriculationB(string $ImmatriculationB): static
    {
        $this->ImmatriculationB = $ImmatriculationB;

        return $this;
    }

    public function getBvehiculeAssurePar(): ?string
    {
        return $this->BvehiculeAssurePar;
    }

    public function setBvehiculeAssurePar(string $BvehiculeAssurePar): static
    {
        $this->BvehiculeAssurePar = $BvehiculeAssurePar;

        return $this;
    }

    public function getAgence(): ?string
    {
        return $this->agence;
    }

    public function setAgence(string $agence): static
    {
        $this->agence = $agence;

        return $this;
    }
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }








}
