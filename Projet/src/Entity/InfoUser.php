<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InfoUserRepository")
 */
class InfoUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Sexe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Age;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Poids;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Taille;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Imc;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tour_taille;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tour_hanche;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $temps_activite_physique;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $intolerance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_regime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(?string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(?string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->Sexe;
    }

    public function setSexe(?string $Sexe): self
    {
        $this->Sexe = $Sexe;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->Age;
    }

    public function setAge(?int $Age): self
    {
        $this->Age = $Age;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->Poids;
    }

    public function setPoids(?int $Poids): self
    {
        $this->Poids = $Poids;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->Taille;
    }

    public function setTaille(?int $Taille): self
    {
        $this->Taille = $Taille;

        return $this;
    }

    public function getTourTaille(): ?int
    {
        return $this->tour_taille;
    }

    public function setTourTaille(?int $tour_taille): self
    {
        $this->tour_taille = $tour_taille;

        return $this;
    }

    public function getTourHanche(): ?int
    {
        return $this->tour_hanche;
    }

    public function setTourHanche(?int $tour_hanche): self
    {
        $this->tour_hanche = $tour_hanche;

        return $this;
    }

    public function getTempsActivitePhysique(): ?int
    {
        return $this->temps_activite_physique;
    }

    public function setTempsActivitePhysique(?int $temps_activite_physique): self
    {
        $this->temps_activite_physique = $temps_activite_physique;

        return $this;
    }

    public function getIntolerance(): ?string
    {
        return $this->intolerance;
    }

    public function setIntolerance(?string $intolerance): self
    {
        $this->intolerance = $intolerance;

        return $this;
    }

    public function getTypeRegime(): ?string
    {
        return $this->type_regime;
    }

    public function setTypeRegime(?string $type_regime): self
    {
        $this->type_regime = $type_regime;

        return $this;
    }

    public function getImc(): ?float
    {
        return $this->Imc;
    }

    public function setImc(?float $Imc): self
    {
        $this->Imc = $Imc;

        return $this;
    }
}
