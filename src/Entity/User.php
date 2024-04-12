<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 40)]
    private ?string $adresse = null;

    #[ORM\Column(length: 40)]
    private ?string $tel = null;

    /**
     * @var Collection<int, Possession>
     */
    #[ORM\OneToMany(targetEntity: Possession::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $possession;

    public function __construct()
    {
        $this->possession = new ArrayCollection();
    }

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return Collection<int, Possession>
     */
    public function getPossession(): Collection
    {
        return $this->possession;
    }

    public function addPossession(Possession $possession): static
    {
        if (!$this->possession->contains($possession)) {
            $this->possession->add($possession);
            $possession->setUser($this);
        }

        return $this;
    }

    public function removePossession(Possession $possession): static
    {
        if ($this->possession->removeElement($possession)) {
            // set the owning side to null (unless already changed)
            if ($possession->getUser() === $this) {
                $possession->setUser(null);
            }
        }

        return $this;
    }
}
