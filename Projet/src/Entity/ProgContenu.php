<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgContenuRepository")
 */
class ProgContenu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Programmes", inversedBy="Recette")
     * @ORM\JoinColumn(nullable=false)
     */
    private $programme;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recette", inversedBy="Programme")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Recette;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgramme(): ?Programmes
    {
        return $this->programme;
    }

    public function setProgramme(?Programmes $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getRecette(): ?Recette
    {
        return $this->Recette;
    }

    public function setRecette(?Recette $Recette): self
    {
        $this->Recette = $Recette;

        return $this;
    }
}
