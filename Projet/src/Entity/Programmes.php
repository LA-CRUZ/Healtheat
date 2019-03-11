<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammesRepository")
 */
class Programmes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_u;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Repas", mappedBy="id_programme")
     */
    private $Repas;

    public function __construct()
    {
        $this->Repas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdU(): ?int
    {
        return $this->id_u;
    }

    public function setIdU(int $id_u): self
    {
        $this->id_u = $id_u;

        return $this;
    }

    /**
     * @return Collection|Repas[]
     */
    public function getRepas(): Collection
    {
        return $this->Repas;
    }

    public function addRepa(Repas $repa): self
    {
        if (!$this->Repas->contains($repa)) {
            $this->Repas[] = $repa;
            $repa->setIdProgramme($this);
        }

        return $this;
    }

    public function removeRepa(Repas $repa): self
    {
        if ($this->Repas->contains($repa)) {
            $this->Repas->removeElement($repa);
            // set the owning side to null (unless already changed)
            if ($repa->getIdProgramme() === $this) {
                $repa->setIdProgramme(null);
            }
        }

        return $this;
    }
}
