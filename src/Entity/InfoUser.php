<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "Veuillez rentrer un age valide",
     *      maxMessage = "Veuillez rentrer un age valide"
     * )
     */
    private $Age;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 50,
     *      max = 250,
     *      minMessage = "Veuillez rentrer une taille valide",
     *      maxMessage = "Veuillez rentrer une taille valide"
     * )
     */
    private $Taille;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Imc;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 25,
     *      max = 150,
     *      minMessage = "Veuillez rentrer un tour de taille valide",
     *      maxMessage = "Veuillez rentrer un tour de taille valide"
     * )
     */
    private $tour_taille;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 50,
     *      max = 200,
     *      minMessage = "Veuillez rentrer un tour de hanche valide",
     *      maxMessage = "Veuillez rentrer un tour de hanche valide"
     * )
     */
    private $tour_hanche;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Intolerance")
     */
    private $intolerance;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Allergie")
     */
    private $allergie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(
     *      min = 40,
     *      max = 300,
     *      minMessage = "Veuillez rentrer un poids valide",
     *      maxMessage = "Veuillez rentrer un poids valide"
     * )
     */
    private $l_poids;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Poids", mappedBy="infoUser", orphanRemoval=true)
     */
    private $poids;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TempsEffortPhy", mappedBy="infoUser", orphanRemoval=true)
     */
    private $temps_activite_physique;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $l_temps;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ingredient")
     */
    private $inventaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Programmes", mappedBy="utilisateur", orphanRemoval=true)
     */
    private $programmes;

    public function __construct()
    {
        $this->intolerance = new ArrayCollection();
        $this->allergie = new ArrayCollection();
        $this->poids = new ArrayCollection();
        $this->temps_activite_physique = new ArrayCollection();
        $this->inventaire = new ArrayCollection();
        $this->programmes = new ArrayCollection();
    }

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

    public function getImc(): ?float
    {
        return $this->Imc;
    }

    public function setImc(?float $Imc): self
    {
        $this->Imc = $Imc;

        return $this;
    }

    /**
     * @return Collection|Intolerance[]
     */
    public function getIntolerance(): Collection
    {
        return $this->intolerance;
    }

    public function addIntolerance(Intolerance $intolerance): self
    {
        if (!$this->intolerance->contains($intolerance)) {
            $this->intolerance[] = $intolerance;
        }

        return $this;
    }

    public function removeIntolerance(Intolerance $intolerance): self
    {
        if ($this->intolerance->contains($intolerance)) {
            $this->intolerance->removeElement($intolerance);
        }

        return $this;
    }

    /**
     * @return Collection|Allergie[]
     */
    public function getAllergie(): Collection
    {
        return $this->allergie;
    }

    public function addAllergie(Allergie $allergie): self
    {
        if (!$this->allergie->contains($allergie)) {
            $this->allergie[] = $allergie;
        }

        return $this;
    }

    public function removeAllergie(Allergie $allergie): self
    {
        if ($this->allergie->contains($allergie)) {
            $this->allergie->removeElement($allergie);
        }

        return $this;
    }

    public function getLPoids(): ?int
    {
        return $this->l_poids;
    }

    public function setLPoids(?int $l_poids): self
    {
        $this->l_poids = $l_poids;

        return $this;
    }

    /**
     * @return Collection|Poids[]
     */
    public function getPoids(): Collection
    {
        return $this->poids;
    }

    public function addPoid(Poids $poid): self
    {
        if (!$this->poids->contains($poid)) {
            $this->poids[] = $poid;
            $poid->setInfoUser($this);
        }

        return $this;
    }

    public function removePoid(Poids $poid): self
    {
        if ($this->poids->contains($poid)) {
            $this->poids->removeElement($poid);
            // set the owning side to null (unless already changed)
            if ($poid->getInfoUser() === $this) {
                $poid->setInfoUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TempsEffortPhy[]
     */
    public function getTempsActivitePhysique(): Collection
    {
        return $this->temps_activite_physique;
    }

    public function addTempsActivitePhysique(TempsEffortPhy $tempsActivitePhysique): self
    {
        if (!$this->temps_activite_physique->contains($tempsActivitePhysique)) {
            $this->temps_activite_physique[] = $tempsActivitePhysique;
            $tempsActivitePhysique->setInfoUser($this);
        }

        return $this;
    }

    public function removeTempsActivitePhysique(TempsEffortPhy $tempsActivitePhysique): self
    {
        if ($this->temps_activite_physique->contains($tempsActivitePhysique)) {
            $this->temps_activite_physique->removeElement($tempsActivitePhysique);
            // set the owning side to null (unless already changed)
            if ($tempsActivitePhysique->getInfoUser() === $this) {
                $tempsActivitePhysique->setInfoUser(null);
            }
        }

        return $this;
    }

    public function getLTemps(): ?int
    {
        return $this->l_temps;
    }

    public function setLTemps(?int $l_temps): self
    {
        $this->l_temps = $l_temps;

        return $this;
    }

    /**
     * @return Collection|Ingredient[]
     */
    public function getInventaire(): Collection
    {
        return $this->inventaire;
    }

    public function addInventaire(Ingredient $inventaire): self
    {
        if (!$this->inventaire->contains($inventaire)) {
            $this->inventaire[] = $inventaire;
        }

        return $this;
    }

    public function removeInventaire(Ingredient $inventaire): self
    {
        if ($this->inventaire->contains($inventaire)) {
            $this->inventaire->removeElement($inventaire);
        }

        return $this;
    }

    /**
     * @return Collection|Programmes[]
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programmes $programme): self
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes[] = $programme;
            $programme->setUtilisateur($this);
        }

        return $this;
    }

    public function removeProgramme(Programmes $programme): self
    {
        if ($this->programmes->contains($programme)) {
            $this->programmes->removeElement($programme);
            // set the owning side to null (unless already changed)
            if ($programme->getUtilisateur() === $this) {
                $programme->setUtilisateur(null);
            }
        }

        return $this;
    }
}