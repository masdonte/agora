<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class Membre implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> Les rôles de l'utilisateur
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string Le mot de passe haché
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 32)]
    private ?string $nomMembre = null;

    #[ORM\Column(length: 20)]
    private ?string $prenomMembre = null;

    #[ORM\Column(length: 14, nullable: true)]
    private ?string $telMembre = null;

    #[ORM\Column(length: 100)]
    private ?string $mailMembre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rueMembre = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $cpMembre = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $villeMembre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Un identifiant visuel qui représente cet utilisateur.
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
        // garantit que chaque utilisateur a au moins ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * S'assure que la session ne contient pas les véritables hachages de mots de passe en les hachant avec CRC32C, comme supporté depuis Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, à supprimer lors de la mise à niveau vers Symfony 8
    }

    public function getNomMembre(): ?string
    {
        return $this->nomMembre;
    }

    public function setNomMembre(string $nomMembre): static
    {
        $this->nomMembre = $nomMembre;

        return $this;
    }

    public function getPrenomMembre(): ?string
    {
        return $this->prenomMembre;
    }

    public function setPrenomMembre(string $prenomMembre): static
    {
        $this->prenomMembre = $prenomMembre;

        return $this;
    }

    public function getTelMembre(): ?string
    {
        return $this->telMembre;
    }

    public function setTelMembre(?string $telMembre): static
    {
        $this->telMembre = $telMembre;

        return $this;
    }

    public function getMailMembre(): ?string
    {
        return $this->mailMembre;
    }

    public function setMailMembre(string $mailMembre): static
    {
        $this->mailMembre = $mailMembre;

        return $this;
    }

    public function getRueMembre(): ?string
    {
        return $this->rueMembre;
    }

    public function setRueMembre(?string $rueMembre): static
    {
        $this->rueMembre = $rueMembre;

        return $this;
    }

    public function getCpMembre(): ?string
    {
        return $this->cpMembre;
    }

    public function setCpMembre(?string $cpMembre): static
    {
        $this->cpMembre = $cpMembre;

        return $this;
    }

    public function getVilleMembre(): ?string
    {
        return $this->villeMembre;
    }

    public function setVilleMembre(?string $villeMembre): static
    {
        $this->villeMembre = $villeMembre;

        return $this;
    }
}
