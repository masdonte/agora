<?php

namespace App\Entity;

use App\Repository\JeuxRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuxRepository::class)]
class Jeux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateParution = null;

    #[ORM\ManyToOne(inversedBy: 'jeuxes')]
    private ?Pegi $idPegi = null;

    #[ORM\ManyToOne(inversedBy: 'jeuxes')]
    private ?Marque $marque = null;

    #[ORM\ManyToOne(inversedBy: 'jeuxes')]
    private ?Genre $genre = null;

    #[ORM\ManyToOne(inversedBy: 'jeuxes')]
    private ?Plateforme $plateforme = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateParution(): ?\DateTime
    {
        return $this->dateParution;
    }

    public function setDateParution(\DateTime $dateParution): static
    {
        $this->dateParution = $dateParution;

        return $this;
    }

    public function getIdPegi(): ?Pegi
    {
        return $this->idPegi;
    }

    public function setIdPegi(?Pegi $idPegi): static
    {
        $this->idPegi = $idPegi;

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPlateforme(): ?Plateforme
    {
        return $this->plateforme;
    }

    public function setPlateforme(?Plateforme $plateforme): static
    {
        $this->plateforme = $plateforme;

        return $this;
    }
}
