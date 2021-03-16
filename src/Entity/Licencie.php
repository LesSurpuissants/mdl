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
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="lesLicencies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $leClub;

    /**
     * @ORM\ManyToOne(targetEntity=Qualite::class, inversedBy="lesLicencies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $laQualite;

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

    public function getLeClub(): ?Club
    {
        return $this->leClub;
    }

    public function setLeClub(?Club $leClub): self
    {
        $this->leClub = $leClub;

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
}
