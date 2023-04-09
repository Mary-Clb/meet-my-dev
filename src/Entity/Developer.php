<?php

namespace App\Entity;

use App\Repository\DeveloperRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeveloperRepository::class)]
class Developer extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $firstname = null;

    #[ORM\Column]
    private ?int $experience = null;

    #[ORM\ManyToMany(targetEntity: Speciality::class, inversedBy: 'developers')]
    private Collection $specialities;

    public function __construct()
    {
        $this->specialities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getname(): ?string
    {
        return $this->name;
    }

    public function setname(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getfirstname(): ?string
    {
        return $this->firstname;
    }

    public function setfirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * @return Collection<int, Speciality>
     */
    public function getSpecialities(): array
    {
        return $this->specialities->toArray();
    }

    public function addSpeciality(Speciality $speciality): self
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities->add($speciality);
        }

        return $this;
    }

    public function removeSpeciality(Speciality $speciality): self
    {
        $this->specialities->removeElement($speciality);

        return $this;
    }
}
