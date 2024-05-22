<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['cin'], message: 'This CIN is already in use.')]
#[UniqueEntity(fields: ['phoneNumber'], message: 'This phoneNumber is already in use.')]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Email cannot be blank.')]
    #[Assert\Email(message: 'Invalid email address.')]

    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'roles cannot be blank.')]

    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]

    private ?string $password = null;
    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'First name cannot be blank.')]
    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: 'First name must be at least {{ limit }} characters long.',
        maxMessage: 'First name cannot be longer than {{ limit }} characters.'
    )]

    private ?string $firstName = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Last name cannot be blank.')]
    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: 'Last name must be at least {{ limit }} characters long.',
        maxMessage: 'Last name cannot be longer than {{ limit }} characters.'
    )]
    private ?string $lastName = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: 'CIN cannot be blank.')]
    #[Assert\Length(
        min: 5,
        max: 10,
        minMessage: 'CIN must be at least {{ limit }} characters long.',
        maxMessage: 'CIN cannot be longer than {{ limit }} characters.'
    )]
        private ?string $cin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Address cannot be null.')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Address must be at least {{ limit }} characters long.',
        maxMessage: 'Address cannot be longer than {{ limit }} characters.'
    )]
    private ?string $address = null;
    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Phone number cannot be blank.')]
    #[Assert\Length(
        min: 8,
        max: 20,
        minMessage: 'Phone number must be at least {{ limit }} characters long.',
        maxMessage: 'Phone number cannot be longer than {{ limit }} characters.'
    )]
    private ?string $phoneNumber = null;

    #[ORM\OneToMany(targetEntity: Reclamation::class, mappedBy: 'user', cascade: ['remove'])]
    private Collection $reclamations;

    #[ORM\Column(nullable: true)]
    private ?array $claims = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageFileName = null;
    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
        $this->roles = ['ROLE_USER']; // Set default role
        $this->quotes = new ArrayCollection();
        $this->requests = new ArrayCollection();

    }


    #[ORM\OneToMany(targetEntity: Quote::class, mappedBy: 'user')]
    private Collection $quotes;

    #[ORM\OneToMany(targetEntity: InsuranceRequest::class, mappedBy: 'user')]
    private Collection $requests;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): static
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setUser($this);
        }

        return $this;
    }
    public function __toString(): string
    {
        return sprintf('%s - %s %s', $this->getCin(), $this->getLastName(), $this->getFirstName());
    }

    public function removeReclamation(Reclamation $reclamation): static
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getUser() === $this) {
                $reclamation->setUser(null);
            }
        }

        return $this;
    }

    public function getClaims(): ?array
    {
        return $this->claims;
    }

    public function setClaims(?array $claims): static
    {
        $this->claims = $claims;

        return $this;
    }

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }

    public function setImageFileName(?string $imageFileName): static
    {
        $this->imageFileName = $imageFileName;

        return $this;
    }

     /**
     * @return Collection<int, Quote>
     */
    public function getQuotes(): Collection
    {
        return $this->quotes;
    }

    public function addQuote(Quote $quote): static
    {
        if (!$this->quotes->contains($quote)) {
            $this->quotes->add($quote);
            $quote->setUser($this);
        }

        return $this;
    }

    public function removeQuote(Quote $quote): static
    {
        if ($this->quotes->removeElement($quote)) {
            // set the owning side to null (unless already changed)
            if ($quote->getUser() === $this) {
                $quote->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, InsuranceRequest>
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(InsuranceRequest $request): static
    {
        if (!$this->requests->contains($request)) {
            $this->requests->add($request);
            $request->setUser($this);
        }

        return $this;
    }

    public function removeRequest(InsuranceRequest $request): static
    {
        if ($this->requests->removeElement($request)) {
            // set the owning side to null (unless already changed)
            if ($request->getUser() === $this) {
                $request->setUser(null);
            }
        }

        return $this;
    }


   
   
}
