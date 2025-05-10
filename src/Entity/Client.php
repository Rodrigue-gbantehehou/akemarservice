<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Commande;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nomClient = null;

    #[ORM\Column(length: 20)]
    private ?string $telephoneClient = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'client')]
    private Collection $Commande;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    private ?User $creerpar = null;

    public function __construct()
    {
        $this->Commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(?string $nomClient): static
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getTelephoneClient(): ?string
    {
        return $this->telephoneClient;
    }

    public function setTelephoneClient(string $telephoneClient): static
    {
        $this->telephoneClient = $telephoneClient;

        return $this;
    }
    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->Commande;
    }

    public function addCommande(Commande $Commande): static
    {
        if (!$this->Commande->contains($Commande)) {
            $this->Commande->add($Commande);
            $Commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $Commande): static
    {
        if ($this->Commande->removeElement($Commande)) {
            // set the owning side to null (unless already changed)
            if ($Commande->getClient() === $this) {
                $Commande->setClient(null);
            }
        }

        return $this;
    }
    public function __tostring()
    {
        return $this->getNomClient();
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function getCreerpar(): ?User
    {
        return $this->creerpar;
    }

    public function setCreerpar(?User $creerpar): static
    {
        $this->creerpar = $creerpar;

        return $this;
    }
}
