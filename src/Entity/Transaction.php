<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $modepaiement = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToOne(inversedBy: 'transaction', cascade: ['persist', 'remove'])]
    private ?Commande $commande_id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?User $client_id = null;

    #[ORM\ManyToOne(inversedBy: 'transactions_employer')]
    private ?User $userCreate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModepaiement(): ?string
    {
        return $this->modepaiement;
    }

    public function setModepaiement(string $modepaiement): self
    {
        $this->modepaiement = $modepaiement;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCommandeId(): ?Commande
    {
        return $this->commande_id;
    }

    public function setCommandeId(?Commande $commande_id): self
    {
        $this->commande_id = $commande_id;

        return $this;
    }

    public function getClientId(): ?User
    {
        return $this->client_id;
    }

    public function setClientId(?User $client_id): self
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function __toString(): string
    {
        return "Transaction - ". $this-> date->format('Y-m-d H:i:s');
    }

    public function getUserCreate(): ?User
    {
        return $this->userCreate;
    }

    public function setUserCreate(?User $userCreate): self
    {
        $this->userCreate = $userCreate;

        return $this;
    }

}
