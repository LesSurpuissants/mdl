<?php

namespace App\Entity;

use App\Repository\ProposerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProposerRepository::class)
 */
class Proposer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $tarifNuite;

    /**
     * @ORM\OneToMany(targetEntity=Nuite::class, mappedBy="proposer")
     */
    private $nuites;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="proposers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hotel;

    public function __construct()
    {
        $this->nuites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarifNuite(): ?int
    {
        return $this->tarifNuite;
    }

    public function setTarifNuite(int $tarifNuite): self
    {
        $this->tarifNuite = $tarifNuite;

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
            $nuite->setProposer($this);
        }

        return $this;
    }

    public function removeNuite(Nuite $nuite): self
    {
        if ($this->nuites->removeElement($nuite)) {
            // set the owning side to null (unless already changed)
            if ($nuite->getProposer() === $this) {
                $nuite->setProposer(null);
            }
        }

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }
}
