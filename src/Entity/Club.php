<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class Club
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Licencie::class, mappedBy="leClub")
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
            $lesLicency->setLeClub($this);
        }

        return $this;
    }

    public function removeLesLicency(Licencie $lesLicency): self
    {
        if ($this->lesLicencies->removeElement($lesLicency)) {
            // set the owning side to null (unless already changed)
            if ($lesLicency->getLeClub() === $this) {
                $lesLicency->setLeClub(null);
            }
        }

        return $this;
    }
}
