<?php

namespace App\Entity;

use App\Repository\NuiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NuiteRepository::class)
 */
class Nuite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNuitee;

    /**
     * @ORM\ManyToOne(targetEntity=Proposer::class, inversedBy="nuites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proposer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNuitee(): ?\DateTimeInterface
    {
        return $this->dateNuitee;
    }

    public function setDateNuitee(\DateTimeInterface $dateNuitee): self
    {
        $this->dateNuitee = $dateNuitee;

        return $this;
    }

    public function getProposer(): ?Proposer
    {
        return $this->proposer;
    }

    public function setProposer(?Proposer $proposer): self
    {
        $this->proposer = $proposer;

        return $this;
    }
}
