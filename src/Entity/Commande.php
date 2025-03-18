<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 20)]
    private ?string $statutcommande = null;

    #[ORM\Column(length: 20)]
    private ?string $prixcommande = null;

    #[ORM\ManyToOne(inversedBy: 'commande')]
    private ?Client $client = null;

    /**
     * @var Collection<int, Stock>
     */
    #[ORM\OneToMany(targetEntity: Stock::class, mappedBy: 'commande')]
    private Collection $stocks;

    

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?User $creerpar = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Facture>
     */
    #[ORM\OneToMany(targetEntity: Facture::class, mappedBy: 'commande')]
    private Collection $factures;

    /**
     * @var Collection<int, Detailcommande>
     */
    #[ORM\OneToMany(targetEntity: Detailcommande::class, mappedBy: 'commande')]
    private Collection $detailcommandes;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->detailcommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

  
    public function getStatutcommande(): ?string
    {
        return $this->statutcommande;
    }

    public function setStatutcommande(string $statutcommande): static
    {
        $this->statutcommande = $statutcommande;

        return $this;
    }

    public function getPrixcommande(): ?string
    {
        return $this->prixcommande;
    }

    public function setPrixcommande(string $prixcommande): static
    {
        $this->prixcommande = $prixcommande;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }


    
    /**
     * @return Collection<int, Stock>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setCommande($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getCommande() === $this) {
                $stock->setCommande(null);
            }
        }

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): static
    {
        if (!$this->factures->contains($facture)) {
            $this->factures->add($facture);
            $facture->setCommande($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): static
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getCommande() === $this) {
                $facture->setCommande(null);
            }
        }

        return $this;
    }
    public function __tostring()
    {
        return $this->getDescription();
    }

    /**
     * @return Collection<int, Detailcommande>
     */
    public function getDetailcommandes(): Collection
    {
        return $this->detailcommandes;
    }

    public function addDetailcommande(Detailcommande $detailcommande): static
    {
        if (!$this->detailcommandes->contains($detailcommande)) {
            $this->detailcommandes->add($detailcommande);
            $detailcommande->setCommande($this);
        }

        return $this;
    }

    public function removeDetailcommande(Detailcommande $detailcommande): static
    {
        if ($this->detailcommandes->removeElement($detailcommande)) {
            // set the owning side to null (unless already changed)
            if ($detailcommande->getCommande() === $this) {
                $detailcommande->setCommande(null);
            }
        }

        return $this;
    }
}
