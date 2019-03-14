<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Produit", inversedBy="recettes")
     */
    private $ingredient;

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
    private $categorie_repas;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $difficulte;

    public function __construct()
    {
        $this->ingredient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getIngredient(): Collection
    {
        return $this->ingredient;
    }

    public function addIngredient(Produit $ingredient): self
    {
        if (!$this->ingredient->contains($ingredient)) {
            $this->ingredient[] = $ingredient;
        }

        return $this;
    }

    public function removeIngredient(Produit $ingredient): self
    {
        if ($this->ingredient->contains($ingredient)) {
            $this->ingredient->removeElement($ingredient);
        }

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

    public function getCategorieRepas(): ?string
    {
        return $this->categorie_repas;
    }

    public function setCategorieRepas(string $categorie_repas): self
    {
        $this->categorie_repas = $categorie_repas;

        return $this;
    }

    public function getDifficulte(): ?string
    {
        return $this->difficulte;
    }

    public function setDifficulte(string $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }
}
