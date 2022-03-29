<?php

namespace App\Entity;

use App\Repository\MaisonReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaisonReservationRepository::class)
 */
class MaisonReservation
{
    public function __construct() {
        $this->setCreatedAt(new \DateTime());
        $this->setStart(new \DateTime());
        $this->setEnd(new \DateTime());
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"}))
     */
    private $createdat;

    /**
     * @ORM\Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"}))
     */
    private $start;

    /**
     * @ORM\Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"}))
     */
    private $end;

    /**
     * @ORM\ManyToOne(targetEntity=Maisonshotes::class, inversedBy="maisonReservations")
     */
    private $maisonshotes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getMaisonshotes(): ?Maisonshotes
    {
        return $this->maisonshotes;
    }

    public function setMaisonshotes(?Maisonshotes $maisonshotes): self
    {
        $this->maisonshotes = $maisonshotes;

        return $this;
    }
}
