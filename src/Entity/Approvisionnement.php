<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Consommable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprovisionnementRepository;

#[ORM\Entity(repositoryClass: ApprovisionnementRepository::class)]
class Approvisionnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'approvisionnements')]
    private ?Consommable $Consommable = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\ManyToOne(inversedBy: 'approvisionnements')]
    private ?User $creerpar = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Quantite = null;

    #[ORM\Column(length: 255)]
    private ?string $Montant = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuantite(): ?string
    {
        return $this->Quantite;
    }

    public function setQuantite(?string $Quantite): static
    {
        $this->Quantite = $Quantite;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->Montant;
    }

    public function setMontant(string $Montant): static
    {
        $this->Montant = $Montant;

        return $this;
    }
}
