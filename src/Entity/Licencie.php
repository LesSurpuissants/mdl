<?php

namespace App\Entity;

use App\Repository\LicencieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LicencieRepository::class)
 */
class Licencie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numLicence;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Qualite::class, inversedBy="lesLicencies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $laQualite;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="licencies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $club;

    /**
     * @ORM\ManyToOne(targetEntity=Qualite::class, inversedBy="licencies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $qualite;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="licencie", cascade={"persist", "remove"})
     */
    private $compte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumLicence(): ?string
    {
        return $this->numLicence;
    }

    public function setNumLicence(string $numLicence): self
    {
        $this->numLicence = $numLicence;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getLaQualite(): ?Qualite
    {
        return $this->laQualite;
    }

    public function setLaQualite(?Qualite $laQualite): self
    {
        $this->laQualite = $laQualite;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getQualite(): ?Qualite
    {
        return $this->qualite;
    }

    public function setQualite(?Qualite $qualite): self
    {
        $this->qualite = $qualite;

        return $this;
    }

    public function getCompte(): ?User
    {
        return $this->compte;
    }

    public function setCompte(?User $compte): self
    {
        $this->compte = $compte;

        return $this;
    }
}
