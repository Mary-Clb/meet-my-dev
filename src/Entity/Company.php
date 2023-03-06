<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $raison_sociale = null;

    #[ORM\Column(length: 50)]
    private ?string $siret = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $localisation = null;

    #[ORM\Column]
    private ?int $employes = null;

    #[ORM\Column]
    private ?bool $publique = null;

    #[ORM\ManyToMany(targetEntity: Activity::class, inversedBy: 'companies')]
    private Collection $Activities;

    public function __construct()
    {
        $this->Activities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raison_sociale;
    }

    public function setRaisonSociale(string $raison_sociale): self
    {
        $this->raison_sociale = $raison_sociale;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getEmployes(): ?int
    {
        return $this->employes;
    }

    public function setEmployes(int $employes): self
    {
        $this->employes = $employes;

        return $this;
    }

    public function isPublique(): ?bool
    {
        return $this->publique;
    }

    public function setPublique(bool $publique): self
    {
        $this->publique = $publique;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivities(): Collection
    {
        return $this->Activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->Activities->contains($activity)) {
            $this->Activities->add($activity);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        $this->Activities->removeElement($activity);

        return $this;
    }
}
