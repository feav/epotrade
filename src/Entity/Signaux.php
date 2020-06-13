<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SignauxRepository")
 */
class Signaux
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_placement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $evenement;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $gain;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function __construct()
    {
        $this->date_placement = new \DateTime();
        $this->gain = 0;
        $this->status = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePlacement(): ?\DateTimeInterface
    {
        return $this->date_placement;
    }

    public function setDatePlacement(\DateTimeInterface $date_placement): self
    {
        $this->date_placement = $date_placement;

        return $this;
    }

    public function getEvenement(): ?string
    {
        return $this->evenement;
    }

    public function setEvenement(string $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }

    public function getGain(): ?float
    {
        return $this->gain;
    }

    public function setGain(float $gain): self
    {
        $this->gain = $gain;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
