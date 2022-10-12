<?php

namespace App\Entity;

use App\Repository\RayonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RayonRepository::class)]
class Rayon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $litterature = null;

    #[ORM\Column(length: 255)]
    private ?string $jeunesse = null;

    #[ORM\Column(length: 255)]
    private ?string $loisirs = null;

    #[ORM\Column(length: 255)]
    private ?string $nature = null;

    #[ORM\Column(length: 255)]
    private ?string $voyages = null;

    #[ORM\Column(length: 255)]
    private ?string $bandesDessinees = null;

    #[ORM\Column(length: 255)]
    private ?string $humour = null;

    #[ORM\Column(length: 255)]
    private ?string $arts = null;

    #[ORM\Column(length: 255)]
    private ?string $societe = null;

    #[ORM\Column(length: 255)]
    private ?string $sciencesHumaines = null;

    #[ORM\Column(length: 255)]
    private ?string $scolaires = null;

    #[ORM\Column(length: 255)]
    private ?string $pedagogie = null;

    #[ORM\Column(length: 255)]
    private ?string $medecine = null;

    #[ORM\Column(length: 255)]
    private ?string $sciences = null;

    #[ORM\Column(length: 255)]
    private ?string $techniques = null;

    #[ORM\Column(length: 255)]
    private ?string $entreprise = null;

    #[ORM\Column(length: 255)]
    private ?string $emploi = null;

    #[ORM\Column(length: 255)]
    private ?string $droits = null;

    #[ORM\Column(length: 255)]
    private ?string $economies = null;

    #[ORM\Column(length: 255)]
    private ?string $langues = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?bool $statut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAp = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLitterature(): ?string
    {
        return $this->litterature;
    }

    public function setLitterature(string $litterature): self
    {
        $this->litterature = $litterature;

        return $this;
    }

    public function getJeunesse(): ?string
    {
        return $this->jeunesse;
    }

    public function setJeunesse(string $jeunesse): self
    {
        $this->jeunesse = $jeunesse;

        return $this;
    }

    public function getLoisirs(): ?string
    {
        return $this->loisirs;
    }

    public function setLoisirs(string $loisirs): self
    {
        $this->loisirs = $loisirs;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getVoyages(): ?string
    {
        return $this->voyages;
    }

    public function setVoyages(string $voyages): self
    {
        $this->voyages = $voyages;

        return $this;
    }

    public function getBandesDessinees(): ?string
    {
        return $this->bandesDessinees;
    }

    public function setBandesDessinees(string $bandesDessinees): self
    {
        $this->bandesDessinees = $bandesDessinees;

        return $this;
    }

    public function getHumour(): ?string
    {
        return $this->humour;
    }

    public function setHumour(string $humour): self
    {
        $this->humour = $humour;

        return $this;
    }

    public function getArts(): ?string
    {
        return $this->arts;
    }

    public function setArts(string $arts): self
    {
        $this->arts = $arts;

        return $this;
    }

    public function getSociete(): ?string
    {
        return $this->societe;
    }

    public function setSociete(string $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getSciencesHumaines(): ?string
    {
        return $this->sciencesHumaines;
    }

    public function setSciencesHumaines(string $sciencesHumaines): self
    {
        $this->sciencesHumaines = $sciencesHumaines;

        return $this;
    }

    public function getScolaires(): ?string
    {
        return $this->scolaires;
    }

    public function setScolaires(string $scolaires): self
    {
        $this->scolaires = $scolaires;

        return $this;
    }

    public function getPedagogie(): ?string
    {
        return $this->pedagogie;
    }

    public function setPedagogie(string $pedagogie): self
    {
        $this->pedagogie = $pedagogie;

        return $this;
    }

    public function getMedecine(): ?string
    {
        return $this->medecine;
    }

    public function setMedecine(string $medecine): self
    {
        $this->medecine = $medecine;

        return $this;
    }

    public function getSciences(): ?string
    {
        return $this->sciences;
    }

    public function setSciences(string $sciences): self
    {
        $this->sciences = $sciences;

        return $this;
    }

    public function getTechniques(): ?string
    {
        return $this->techniques;
    }

    public function setTechniques(string $techniques): self
    {
        $this->techniques = $techniques;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getEmploi(): ?string
    {
        return $this->emploi;
    }

    public function setEmploi(string $emploi): self
    {
        $this->emploi = $emploi;

        return $this;
    }

    public function getDroits(): ?string
    {
        return $this->droits;
    }

    public function setDroits(string $droits): self
    {
        $this->droits = $droits;

        return $this;
    }

    public function getEconomies(): ?string
    {
        return $this->economies;
    }

    public function setEconomies(string $economies): self
    {
        $this->economies = $economies;

        return $this;
    }

    public function getLangues(): ?string
    {
        return $this->langues;
    }

    public function setLangues(string $langues): self
    {
        $this->langues = $langues;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUpdatedAp(): ?\DateTimeInterface
    {
        return $this->updatedAp;
    }

    public function setUpdatedAp(?\DateTimeInterface $updatedAp): self
    {
        $this->updatedAp = $updatedAp;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }
}
