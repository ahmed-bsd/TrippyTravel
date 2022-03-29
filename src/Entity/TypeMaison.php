<?php

namespace App\Entity;

use App\Repository\TypeMaisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=TypeMaisonRepository::class)
 */
class TypeMaison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $pub;

    ///**
     //* @ORM\OneToMany(targetEntity=Maisonshotes::class, mappedBy="typeMaison", cascade={"persist", "remove"})
     //*/
    //private $maisons;

    public function __ToString()
    {
        return $this->getLibelle()  ;
    }

    public function __construct()
    {
        $this->maisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPub(): ?bool
    {
        return $this->pub;
    }

    public function setPub(bool $pub): self
    {
        $this->pub = $pub;

        return $this;
    }



    public function removeMaison(Maisonshotes $maison): self
    {
        if ($this->maisons->removeElement($maison)) {
            // set the owning side to null (unless already changed)
            if ($maison->getTypeMaison() === $this) {
                $maison->setTypeMaison(null);
            }
        }

        return $this;
    }
}
