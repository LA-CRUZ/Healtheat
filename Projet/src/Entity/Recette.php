<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RecetteRepository")
 */
class Recette
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Image;

    /**
     * @ORM\Column(type="array")
     */
    private $ingredient = [];

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $kcal;

    /**
     * @ORM\Column(type="integer")
     */
    private $temps_prep;

    /**
     * @ORM\Column(type="integer")
     */
    private $temps_cuisson;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $appareil;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_repas;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $catégorie_repas;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function getIngredient(): ?array
    {
        return $this->ingredient;
    }

    public function setIngredient(array $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getKcal(): ?int
    {
        return $this->kcal;
    }

    public function setKcal(int $kcal): self
    {
        $this->kcal = $kcal;

        return $this;
    }

    public function getTempsPrep(): ?int
    {
        return $this->temps_prep;
    }

    public function setTempsPrep(int $temps_prep): self
    {
        $this->temps_prep = $temps_prep;

        return $this;
    }

    public function getTempsCuisson(): ?int
    {
        return $this->temps_cuisson;
    }

    public function setTempsCuisson(int $temps_cuisson): self
    {
        $this->temps_cuisson = $temps_cuisson;

        return $this;
    }

    public function getAppareil(): ?string
    {
        return $this->appareil;
    }

    public function setAppareil(string $appareil): self
    {
        $this->appareil = $appareil;

        return $this;
    }

    public function getTypeRepas(): ?string
    {
        return $this->type_repas;
    }

    public function setTypeRepas(string $type_repas): self
    {
        $this->type_repas = $type_repas;

        return $this;
    }

    public function getCatégorieRepas(): ?string
    {
        return $this->catégorie_repas;
    }

    public function setCatégorieRepas(string $catégorie_repas): self
    {
        $this->catégorie_repas = $catégorie_repas;

        return $this;
    }
}
