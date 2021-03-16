<?php

namespace App\Entity;

use App\Repository\QualiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QualiteRepository::class)
 */
class Qualite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Licencie::class, mappedBy="laQualite")
     */
    private $lesLicencies;

    public function __construct()
    {
        $this->lesLicencies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Licencie[]
     */
    public function getLesLicencies(): Collection
    {
        return $this->lesLicencies;
    }

    public function addLesLicency(Licencie $lesLicency): self
    {
        if (!$this->lesLicencies->contains($lesLicency)) {
            $this->lesLicencies[] = $lesLicency;
            $lesLicency->setLaQualite($this);
        }

        return $this;
    }

    public function removeLesLicency(Licencie $lesLicency): self
    {
        if ($this->lesLicencies->removeElement($lesLicency)) {
            // set the owning side to null (unless already changed)
            if ($lesLicency->getLaQualite() === $this) {
                $lesLicency->setLaQualite(null);
            }
        }

        return $this;
    }
}
