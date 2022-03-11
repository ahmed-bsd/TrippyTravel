<?php

namespace App\Entity;

use App\Repository\ExcursionreservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ExcursionreservationRepository::class)
 */
class Excursionreservation
{
    public function __construct() {
        $this->setCreatedAt(new \DateTime());
    }
    const RESERVATION_EXCURSION_DEFAULT = "reservation.non_paye";
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("excursion")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("excursion")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("excursion")
     */
    private $status=self::RESERVATION_EXCURSION_DEFAULT;

    /**
     * @ORM\Column(type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Excursion::class, inversedBy="excursionreservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $excursion;



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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getExcursion(): ?Excursion
    {
        return $this->excursion;
    }

    public function setExcursion(?Excursion $excursion): self
    {
        $this->excursion = $excursion;

        return $this;
    }


}
