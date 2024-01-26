<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max:255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max:255)]
    private ?string $Forname = null;

    #[ORM\Column(length: 255)]
    private ?string $Phone = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min:2, max:255)]
    private ?string $Agency = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email()]
    #[Assert\Length(min:2, max:180)]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?string $password = 'password';


    private ?string $plainPassword = null;

    #[ORM\OneToOne(mappedBy: 'Users', cascade: ['persist', 'remove'])]
    private ?UsersFormTemplate $usersFormTemplate = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: FormReponse::class)]
    private Collection $FormResponse;

    public function __construct()
    {
        $this->FormResponse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getForname(): ?string
    {
        return $this->Forname;
    }

    public function setForname(string $Forname): static
    {
        $this->Forname = $Forname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(string $Phone): static
    {
        $this->Phone = $Phone;

        return $this;
    }

    public function getAgency(): ?string
    {
        return $this->Agency;
    }

    public function setAgency(string $Agency): static
    {
        $this->Agency = $Agency;

        return $this;
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

    public function eraseCredentials(): void
{
    $this->plainPassword = null;
}

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

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
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUsersFormTemplate(): ?UsersFormTemplate
    {
        return $this->usersFormTemplate;
    }

    public function setUsersFormTemplate(?UsersFormTemplate $usersFormTemplate): static
    {
        // unset the owning side of the relation if necessary
        if ($usersFormTemplate === null && $this->usersFormTemplate !== null) {
            $this->usersFormTemplate->setUsers(null);
        }

        // set the owning side of the relation if necessary
        if ($usersFormTemplate !== null && $usersFormTemplate->getUsers() !== $this) {
            $usersFormTemplate->setUsers($this);
        }

        $this->usersFormTemplate = $usersFormTemplate;

        return $this;
    }

    /**
     * @return Collection<int, FormReponse>
     */
    public function getFormResponse(): Collection
    {
        return $this->FormResponse;
    }

    public function addFormResponse(FormReponse $formResponse): static
    {
        if (!$this->FormResponse->contains($formResponse)) {
            $this->FormResponse->add($formResponse);
            $formResponse->setUser($this);
        }

        return $this;
    }

    public function removeFormResponse(FormReponse $formResponse): static
    {
        if ($this->FormResponse->removeElement($formResponse)) {
            // set the owning side to null (unless already changed)
            if ($formResponse->getUser() === $this) {
                $formResponse->setUser(null);
            }
        }

        return $this;
    }
}
