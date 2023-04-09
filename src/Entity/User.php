<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(['developer' => Developer::class, 'company' => Company::class])]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username', groups: ["Unique"])]
#[UniqueEntity(fields: ['mail'], message: 'There is already an account with this email', groups: ["Unique"])]
#[UniqueEntity(fields: ['telephone'], message: 'There is already an account with this telephone number', groups: ["Unique"])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $presentation = null;

    #[ORM\Column(length: 30, unique: true, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 150, unique: true)]
    private ?string $mail = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Get the value of mail
     */ 
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */ 
    public function setMail($mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of telephone
     */ 
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * Set the value of telephone
     *
     * @return  self
     */ 
    public function setTelephone($telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get the value of presentation
     */ 
    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    /**
     * Set the value of presentation
     *
     * @return  self
     */ 
    public function setPresentation($presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }
}
