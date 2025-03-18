<?php

namespace App\Entity;

use App\Entity\Stock;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Approvisionnement;
use App\Repository\ConsommableRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ConsommableRepository::class)]
class Consommable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeduconsommable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typepapier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $formatsupport = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prixunit = null;

    /**
     * @var Collection<int, Stock>
     */
    #[ORM\OneToMany(targetEntity: Stock::class, mappedBy: 'consommable')]
    private Collection $Stock;



    /**
     * @var Collection<int, Approvisionnement>
     */
    #[ORM\OneToMany(targetEntity: Approvisionnement::class, mappedBy: 'consommmable')]
    private Collection $Approvisionnement;

    

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $qtedispo = null;

    /**
     * @var Collection<int, Detailcommande>
     */
    #[ORM\OneToMany(targetEntity: Detailcommande::class, mappedBy: 'consommable')]
    private Collection $detailcommandes;

    

    public function __construct()
    {
        $this->Stock = new ArrayCollection();
        $this->Approvisionnement = new ArrayCollection();
        $this->detailcommandes = new ArrayCollection();
        
    
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTypeduconsommable(): ?string
    {
        return $this->typeduconsommable;
    }

    public function setTypeduconsommable(?string $typeduconsommable): static
    {
        $this->typeduconsommable = $typeduconsommable;

        return $this;
    }


    public function getTypepapier(): ?string
    {
        return $this->typepapier;
    }

    public function setTypepapier(?string $typepapier): static
    {
        $this->typepapier = $typepapier;

        return $this;
    }

    public function getFormatsupport(): ?string
    {
        return $this->formatsupport;
    }

    public function setFormatsupport(?string $formatsupport): static
    {
        $this->formatsupport = $formatsupport;

        return $this;
    }

    public function getPrixunit(): ?string
    {
        return $this->prixunit;
    }

    public function setPrixunit(?string $prixunit): static
    {
        $this->prixunit = $prixunit;

        return $this;
    }

    /**
     * @return Collection<int, Stock>
     */
    public function getStock(): Collection
    {
        return $this->Stock;
    }

    public function addStock(Stock $Stock): static
    {
        if (!$this->Stock->contains($Stock)) {
            $this->Stock->add($Stock);
            $Stock->setConsommable($this);
        }

        return $this;
    }

    public function removeStock(Stock $Stock): static
    {
        if ($this->Stock->removeElement($Stock)) {
            // set the owning side to null (unless already changed)
            if ($Stock->getConsommable() === $this) {
                $Stock->setConsommable(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Approvisionnement>
     */
    public function getApprovisionnement(): Collection
    {
        return $this->Approvisionnement;
    }

    public function addApprovisionnement(Approvisionnement $Approvisionnement): static
    {
        if (!$this->Approvisionnement->contains($Approvisionnement)) {
            $this->Approvisionnement->add($Approvisionnement);
            $Approvisionnement->setConsommable($this);
        }

        return $this;
    }

    public function removeApprovisionnement(Approvisionnement $Approvisionnement): static
    {
        if ($this->Approvisionnement->removeElement($Approvisionnement)) {
            // set the owning side to null (unless already changed)
            if ($Approvisionnement->getConsommable() === $this) {
                $Approvisionnement->setConsommable(null);
            }
        }

        return $this;
    }

    
    public function __tostring()
    {
        return $this->getTypepapier().' '.$this->getFormatsupport();
    }

    public function getQtedispo(): ?string
    {
        return $this->qtedispo;
    }

    public function setQtedispo(?string $qtedispo): static
    {
        $this->qtedispo = $qtedispo;

        return $this;
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
            $detailcommande->setConsommable($this);
        }

        return $this;
    }

    public function removeDetailcommande(Detailcommande $detailcommande): static
    {
        if ($this->detailcommandes->removeElement($detailcommande)) {
            // set the owning side to null (unless already changed)
            if ($detailcommande->getConsommable() === $this) {
                $detailcommande->setConsommable(null);
            }
        }

        return $this;
    }

    
}
