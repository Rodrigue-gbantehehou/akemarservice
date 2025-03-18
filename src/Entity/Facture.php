<?php

namespace App\Entity;

use App\Entity\Commande;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FactureRepository;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Reference = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $montant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $moyenpaiemant = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datefacture = null;

    #[ORM\Column(nullable: true)]
    private ?float $TVA = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    private ?Commande $Commande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resteapayer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(?string $Reference): static
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(?string $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMoyenpaiemant(): ?string
    {
        return $this->moyenpaiemant;
    }

    public function setMoyenpaiemant(?string $moyenpaiemant): static
    {
        $this->moyenpaiemant = $moyenpaiemant;

        return $this;
    }

    public function getDatefacture(): ?\DateTimeInterface
    {
        return $this->datefacture;
    }

    public function setDatefacture(?\DateTimeInterface $datefacture): static
    {
        $this->datefacture = $datefacture;

        return $this;
    }

    public function getTVA(): ?float
    {
        return $this->TVA;
    }

    public function setTVA(?float $TVA): static
    {
        $this->TVA = $TVA;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->Commande;
    }

    public function setCommande(?Commande $Commande): static
    {
        $this->Commande = $Commande;

        return $this;
    }

    public function __tostring()
    {
        $date=$this->getDatefacture();
        $dateformat= $date->format('d/m/y');
        return $dateformat;
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

    public function getResteapayer(): ?string
    {
        return $this->resteapayer;
    }

    public function setResteapayer(?string $resteapayer): static
    {
        $this->resteapayer = $resteapayer;

        return $this;
    }
}
