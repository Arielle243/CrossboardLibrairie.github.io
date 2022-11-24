<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statutCommande = null;


    #[ORM\OneToMany(mappedBy: 'commandes', targetEntity: Lignecommande::class, orphanRemoval: true)]
    private Collection $lignecommandes;

    #[ORM\ManyToOne(inversedBy: 'commande')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: LignePanier::class, mappedBy: 'commandes')]
    private Collection $lignePaniers;

    #[ORM\OneToMany(mappedBy: 'commandes', targetEntity: Livraison::class, orphanRemoval: true)]
    private Collection $livraisons;


    public function __construct()
    {
        $this->lignecommandes = new ArrayCollection();
        $this->lignePaniers = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getStatutCommande(): ?string
    {
        return $this->statutCommande;
    }

    public function setStatutCommande(?string $statutCommande): self
    {
        $this->statutCommande = $statutCommande;

        return $this;
    }




    /**
     * @return Collection<int, Lignecommande>
     */
    public function getLignecommandes(): Collection
    {
        return $this->lignecommandes;
    }

    public function addLignecommande(Lignecommande $lignecommande): self
    {
        if (!$this->lignecommandes->contains($lignecommande)) {
            $this->lignecommandes->add($lignecommande);
            $lignecommande->setCommandes($this);
        }

        return $this;
    }

    public function removeLignecommande(Lignecommande $lignecommande): self
    {
        if ($this->lignecommandes->removeElement($lignecommande)) {
            // set the owning side to null (unless already changed)
            if ($lignecommande->getCommandes() === $this) {
                $lignecommande->setCommandes(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    } 

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, LignePanier>
     */
    public function getLignePaniers(): Collection
    {
        return $this->lignePaniers;
    }

    public function addLignePanier(LignePanier $lignePanier): self
    {
        if (!$this->lignePaniers->contains($lignePanier)) {
            $this->lignePaniers->add($lignePanier);
            $lignePanier->addCommande($this);
        }

        return $this;
    }

    public function removeLignePanier(LignePanier $lignePanier): self
    {
        if ($this->lignePaniers->removeElement($lignePanier)) {
            $lignePanier->removeCommande($this);
        }

        return $this;
    }


     public function __toString(): string
 {
     return $this->title;
     
 }

     /**
      * @return Collection<int, Livraison>
      */
     public function getLivraisons(): Collection
     {
         return $this->livraisons;
     }

     public function addLivraison(Livraison $livraison): self
     {
         if (!$this->livraisons->contains($livraison)) {
             $this->livraisons->add($livraison);
             $livraison->setCommandes($this);
         }

         return $this;
     }

     public function removeLivraison(Livraison $livraison): self
     {
         if ($this->livraisons->removeElement($livraison)) {
             // set the owning side to null (unless already changed)
             if ($livraison->getCommandes() === $this) {
                 $livraison->setCommandes(null);
             }
         }

         return $this;
     }
}
