<?php

namespace App\Entity;

use App\Entity\Consommable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DetailcommandeRepository;

#[ORM\Entity(repositoryClass: DetailcommandeRepository::class)]
class Detailcommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prix = null;

    #[ORM\ManyToOne(inversedBy: 'detailcommandes')]
    private ?Consommable $Consommable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dimension = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createAlt = null;

    #[ORM\ManyToOne(inversedBy: 'detailcommandes')]
    private ?Commande $commande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $qteconsommable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $qtecommande = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getConsommable(): ?Consommable
    {
        return $this->Consommable;
    }

    public function setConsommable(?Consommable $Consommable): static
    {
        $this->Consommable = $Consommable;

        return $this;
    }

    public function getDimension(): ?string
    {
        return $this->dimension;
    }

    public function setDimension(?string $dimension): static
    {
        $this->dimension = $dimension;

        return $this;
    }

    public function getCreateAlt(): ?\DateTimeInterface
    {
        return $this->createAlt;
    }

    public function setCreateAlt(?\DateTimeInterface $createAlt): static
    {
        $this->createAlt = $createAlt;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    public function getQteconsommable(): ?string
    {
        return $this->qteconsommable;
    }

    public function setQteconsommable(?string $qteconsommable): static
    {
        $this->qteconsommable = $qteconsommable;

        return $this;
    }

    public function getQtecommande(): ?string
    {
        return $this->qtecommande;
    }

    public function setQtecommande(?string $qtecommande): static
    {
        $this->qtecommande = $qtecommande;

        return $this;
    }
}
