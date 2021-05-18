<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateInscription;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="inscription", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $compte;

    /**
     * @ORM\ManyToMany(targetEntity=Atelier::class, mappedBy="inscriptions")
     */
    private $ateliers;

    /**
     * @ORM\OneToMany(targetEntity=Restauration::class, mappedBy="inscription")
     */
    private $restaurations;

    /**
     * @ORM\ManyToMany(targetEntity=Nuite::class)
     */
    private $nuites;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    public function __construct()
    {
        $this->ateliers = new ArrayCollection();
        $this->restaurations = new ArrayCollection();
        $this->nuites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getCompte(): ?User
    {
        return $this->compte;
    }

    public function setCompte(User $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * @return Collection|Atelier[]
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    public function addAtelier(Atelier $atelier): self
    {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers[] = $atelier;
            $atelier->addInscription($this);
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): self
    {
        if ($this->ateliers->removeElement($atelier)) {
            $atelier->removeInscription($this);
        }

        return $this;
    }

    /**
     * @return Collection|Restauration[]
     */
    public function getRestaurations(): Collection
    {
        return $this->restaurations;
    }

    public function addRestauration(Restauration $restauration): self
    {
        if (!$this->restaurations->contains($restauration)) {
            $this->restaurations[] = $restauration;
            $restauration->setInscription($this);
        }

        return $this;
    }

    public function removeRestauration(Restauration $restauration): self
    {
        if ($this->restaurations->removeElement($restauration)) {
            // set the owning side to null (unless already changed)
            if ($restauration->getInscription() === $this) {
                $restauration->setInscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Nuite[]
     */
    public function getNuites(): Collection
    {
        return $this->nuites;
    }

    public function addNuite(Nuite $nuite): self
    {
        if (!$this->nuites->contains($nuite)) {
            $this->nuites[] = $nuite;
        }

        return $this;
    }

    public function removeNuite(Nuite $nuite): self
    {
        $this->nuites->removeElement($nuite);

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
