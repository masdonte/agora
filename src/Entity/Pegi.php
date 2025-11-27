<?php

namespace App\Entity;

use App\Repository\PegiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PegiRepository::class)]
class Pegi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Age = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    /**
     * @var Collection<int, Jeux>
     */
    #[ORM\OneToMany(targetEntity: Jeux::class, mappedBy: 'idPegi')]
    private Collection $jeuxes;

    public function __construct()
    {
        $this->jeuxes = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?int
    {
        return $this->Age;
    }

    public function setAge(int $Age): static
    {
        $this->Age = $Age;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Jeux>
     */
    public function getJeuxes(): Collection
    {
        return $this->jeuxes;
    }

    public function addJeux(Jeux $jeux): static
    {
        if (!$this->jeuxes->contains($jeux)) {
            $this->jeuxes->add($jeux);
            $jeux->setIdPegi($this);
        }

        return $this;
    }

    public function removeJeux(Jeux $jeux): static
    {
        if ($this->jeuxes->removeElement($jeux)) {
            // set the owning side to null (unless already changed)
            if ($jeux->getIdPegi() === $this) {
                $jeux->setIdPegi(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->Age;
    }

}