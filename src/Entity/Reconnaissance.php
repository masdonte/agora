<?php

namespace App\Entity;

use App\Repository\ReconnaissanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReconnaissanceRepository::class)]
// Les entités de la classe reconnaissance 
class Reconnaissance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Niveau = null;
    // Ici le lien avec la table CatTournois 

    #[ORM\ManyToOne(inversedBy: 'reconnaissances')]
    private ?CatTournois $reconnaissance_tournoi = null;

    // Get qui sert à récupérer les données de l'entité reconnaissance et set qui sert à les modifier

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->Niveau;
    }

    public function setNiveau(string $Niveau): static
    {
        $this->Niveau = $Niveau;

        return $this;
    }

    public function getReconnaissanceTournoi(): ?CatTournois
    {
        return $this->reconnaissance_tournoi;
    }

    public function setReconnaissanceTournoi(?CatTournois $reconnaissance_tournoi): static
    {
        $this->reconnaissance_tournoi = $reconnaissance_tournoi;

        return $this;
    }
}
