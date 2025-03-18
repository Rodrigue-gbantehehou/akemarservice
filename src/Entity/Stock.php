<?php

namespace App\Entity;

use App\Entity\Consommable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StockRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $stock = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datemisajourstock = null;

    #[ORM\ManyToOne(inversedBy: 'stocks')]
    private ?commande $commande = null;

  
    

    #[ORM\ManyToOne(inversedBy: 'stock')]
    private ?Consommable $consommable = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(?string $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getDatemisajourstock(): ?\DateTimeInterface
    {
        return $this->datemisajourstock;
    }

    public function setDatemisajourstock(?\DateTimeInterface $datemisajourstock): static
    {
        $this->datemisajourstock = $datemisajourstock;

        return $this;
    }

    public function getCommande(): ?commande
    {
        return $this->commande;
    }

    public function setCommande(?commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

   


    public function getConsommable(): ?Consommable
    {
        return $this->consommable;
    }

    public function setConsommable(?Consommable $consommable): static
    {
        $this->consommable = $consommable;

        return $this;
    }
}
