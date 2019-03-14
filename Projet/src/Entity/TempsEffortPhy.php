<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TempsEffortPhyRepository")
 */
class TempsEffortPhy
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
    private $temps;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InfoUser", inversedBy="temps_activite_physique")
     * @ORM\JoinColumn(nullable=false)
     */
    private $infoUser;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemps(): ?int
    {
        return $this->temps;
    }

    public function setTemps(int $temps): self
    {
        $this->temps = $temps;

        return $this;
    }

    public function getInfoUser(): ?InfoUser
    {
        return $this->infoUser;
    }

    public function setInfoUser(?InfoUser $infoUser): self
    {
        $this->infoUser = $infoUser;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
