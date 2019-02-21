<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRegimeRepository")
 */
class TypeRegime
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Vegan;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Vegetarien;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVegan(): ?bool
    {
        return $this->Vegan;
    }

    public function setVegan(?bool $Vegan): self
    {
        $this->Vegan = $Vegan;

        return $this;
    }

    public function getVegetarien(): ?bool
    {
        return $this->Vegetarien;
    }

    public function setVegetarien(?bool $Vegetarien): self
    {
        $this->Vegetarien = $Vegetarien;

        return $this;
    }
}
