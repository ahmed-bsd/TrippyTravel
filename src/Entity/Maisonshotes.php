<?php

namespace App\Entity;

use App\Repository\MaisonshotesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=MaisonshotesRepository::class)
 *  @Vich\Uploadable
 */
class Maisonshotes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\
     * NotBlank(message="verfier svp")
     */

    private $libelle;

    /**
     * @ORM\Column(type="integer")
     * @Assert\
     * Length(max=10)
     */


    private $capacite;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\
     * Length(max=10)
     */

    private $localisation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\
     * Length(max=10)
     */

    private $proprietaire;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrChambres;

    /**
     * @ORM\ManyToOne(targetEntity=TypeMaison::class, inversedBy="maisons")
     */
    private $typeMaison;

    /**
     * @ORM\OneToMany(targetEntity=Maisonhoteimage::class, mappedBy="maisonshotes", cascade={"persist", "remove"})
     */
    private $maisonhotesimages;

    /**
     * @ORM\OneToMany(targetEntity=MaisonReservation::class, mappedBy="maisonshotes",cascade={"persist", "remove"})
     */
    private $maisonReservations;

    public function __construct()
    {
        $this->maisonhotesimages = new ArrayCollection();
        $this->maisonReservations = new ArrayCollection();
    }






    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getProprietaire(): ?string
    {
        return $this->proprietaire;
    }

    public function setProprietaire(string $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getNbrChambres(): ?int
    {
        return $this->nbrChambres;
    }

    public function setNbrChambres(int $nbrChambres): self
    {
        $this->nbrChambres = $nbrChambres;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getTypeMaison(): ?TypeMaison
    {
        return $this->typeMaison;
    }

    public function setTypeMaison(?TypeMaison $typeMaison): self
    {
        $this->typeMaison = $typeMaison;

        return $this;
    }

    /**
     * @return Collection|Maisonhoteimage[]
     */
    public function getMaisonhotesimages(): Collection
    {
        return $this->maisonhotesimages;
    }

    public function addMaisonhotesimage(Maisonhoteimage $maisonhotesimage): self
    {
        if (!$this->maisonhotesimages->contains($maisonhotesimage)) {
            $this->maisonhotesimages[] = $maisonhotesimage;
            $maisonhotesimage->setMaisonshotes($this);
        }

        return $this;
    }

    public function removeMaisonhotesimage(Maisonhoteimage $maisonhotesimage): self
    {
        if ($this->maisonhotesimages->removeElement($maisonhotesimage)) {
            // set the owning side to null (unless already changed)
            if ($maisonhotesimage->getMaisonshotes() === $this) {
                $maisonhotesimage->setMaisonshotes(null);
            }
        }

        return $this;
    }
    public function __toString(){

    }

    /**
     * @return Collection|MaisonReservation[]
     */
    public function getMaisonReservations(): Collection
    {
        return $this->maisonReservations;
    }

    public function addMaisonReservation(MaisonReservation $maisonReservation): self
    {
        if (!$this->maisonReservations->contains($maisonReservation)) {
            $this->maisonReservations[] = $maisonReservation;
            $maisonReservation->setMaisonshotes($this);
        }

        return $this;
    }

    public function removeMaisonReservation(MaisonReservation $maisonReservation): self
    {
        if ($this->maisonReservations->removeElement($maisonReservation)) {
            // set the owning side to null (unless already changed)
            if ($maisonReservation->getMaisonshotes() === $this) {
                $maisonReservation->setMaisonshotes(null);
            }
        }

        return $this;
    }


}
