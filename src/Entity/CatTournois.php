<?php

namespace App\Entity;

use App\Repository\CatTournoisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatTournoisRepository::class)]
class CatTournois
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    /**
     * @var Collection<int, Tournoi>
     */
    #[ORM\OneToMany(targetEntity: Tournoi::class, mappedBy: 'categorie')]
    private Collection $tournois;

    /**
     * @var Collection<int, Reconnaissance>
     */
    #[ORM\OneToMany(targetEntity: Reconnaissance::class, mappedBy: 'reconnaissance_tournoi')]
    private Collection $reconnaissances;

    public function __construct()
    {
        $this->tournois = new ArrayCollection();
        $this->reconnaissances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Tournoi>
     */
    public function getTournois(): Collection
    {
        return $this->tournois;
    }

    public function addTournoi(Tournoi $tournoi): static
    {
        if (!$this->tournois->contains($tournoi)) {
            $this->tournois->add($tournoi);
            $tournoi->setCategorie($this);
        }

        return $this;
    }

    public function removeTournoi(Tournoi $tournoi): static
    {
        if ($this->tournois->removeElement($tournoi)) {
            // set the owning side to null (unless already changed)
            if ($tournoi->getCategorie() === $this) {
                $tournoi->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString(): string 
    {
        return $this->libelle;
    }

    /**
     * @return Collection<int, Reconnaissance>
     */
    public function getReconnaissances(): Collection
    {
        return $this->reconnaissances;
    }

    public function addReconnaissance(Reconnaissance $reconnaissance): static
    {
        if (!$this->reconnaissances->contains($reconnaissance)) {
            $this->reconnaissances->add($reconnaissance);
            $reconnaissance->setReconnaissanceTournoi($this);
        }

        return $this;
    }

    public function removeReconnaissance(Reconnaissance $reconnaissance): static
    {
        if ($this->reconnaissances->removeElement($reconnaissance)) {
            // set the owning side to null (unless already changed)
            if ($reconnaissance->getReconnaissanceTournoi() === $this) {
                $reconnaissance->setReconnaissanceTournoi(null);
            }
        }

        return $this;
    }
}
