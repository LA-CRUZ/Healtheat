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
     * @ORM\ManyToOne(targetEntity="App\Entity\InfoUser", inversedBy="programmes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_debut;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProgContenu", mappedBy="programme", orphanRemoval=true)
     */
    private $Recette;

    public function __construct()
    {
        $this->Recette = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?InfoUser
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?InfoUser $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    /**
     * @return Collection|ProgContenu[]
     */
    public function getRecette(): Collection
    {
        return $this->Recette;
    }

    public function addRecette(ProgContenu $recette): self
    {
        if (!$this->Recette->contains($recette)) {
            $this->Recette[] = $recette;
            $recette->setProgramme($this);
        }

        return $this;
    }

    public function removeRecette(ProgContenu $recette): self
    {
        if ($this->Recette->contains($recette)) {
            $this->Recette->removeElement($recette);
            // set the owning side to null (unless already changed)
            if ($recette->getProgramme() === $this) {
                $recette->setProgramme(null);
            }
        }

        return $this;
    }
}
