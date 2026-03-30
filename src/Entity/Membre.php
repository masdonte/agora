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
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 32)]
    private ?string $nomMembre = null;

    #[ORM\Column(length: 20)]
    private ?string $prenommembre = null;

    #[ORM\Column(length: 14, nullable: true)]
    private ?string $telMembre = null;

    #[ORM\Column(length: 70)]
    private ?string $mailMembre = null;

    #[ORM\Column(length: 70)]
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
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
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
        // @deprecated, to be removed when upgrading to Symfony 8
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

    public function getPrenommembre(): ?string
    {
        return $this->prenommembre;
    }

    public function setPrenommembre(string $prenommembre): static
    {
        $this->prenommembre = $prenommembre;

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

    public function getVilleMembre(): ?string
    {
        return $this->villeMembre;
    }

    public function setVilleMembre(string $villeMembre): static
    {
        $this->villeMembre = $villeMembre;

        return $this;
    }
}
