<?php

namespace App\Entity;

use App\Repository\LignecommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LignecommandeRepository::class)]
class Lignecommande 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'lignecommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commandes = null;

    #[ORM\ManyToOne(inversedBy: 'lignecommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

/*  */
/*     public function __construct() */
/*     { */
/*         $this->product = new ArrayCollection(); */
/*     } */
/*  */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }



    public function getCommandes(): ?Commande
    {
        return $this->commandes;
    }

    public function setCommandes(?Commande $commandes): self
    {
        $this->commandes = $commandes;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
