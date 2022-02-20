<?php

namespace App\Entity;

use App\Repository\ExcursionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=ExcursionRepository::class)
 * @Vich\Uploadable()
 */
class Excursion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $ville;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     * @Assert\Type(
     *     type="float",
     *     message="La valeur {{ value }} est non valide {{ type }}."
     * )
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Excursioncategorie::class, inversedBy="excursions")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Ce champ est obligatoire")
     */
    private $excursioncategorie;


    /**
     * @ORM\OneToMany(targetEntity=Excursionimage::class, mappedBy="excursion", cascade={"persist", "remove"})
     */
    private $excursionimages;




    public function __construct()
    {
        $this->excursionimages = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

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

    public function getExcursioncategorie(): ?excursioncategorie
    {
        return $this->excursioncategorie;
    }

    public function setExcursioncategorie(?excursioncategorie $excursioncategorie): self
    {
        $this->excursioncategorie = $excursioncategorie;

        return $this;
    }


    /**
     * @return Collection<int, Excursionimage>
     */
    public function getExcursionimages(): Collection
    {
        return $this->excursionimages;
    }

    public function addExcursionimage(Excursionimage $excursionimage): self
    {
//        if (!$this->excursionimages->contains($excursionimage)) {
//            $this->excursionimages[] = $excursionimage;
//            $excursionimage->setExcursion($this);
//        }
//
//        return $this;
        $excursionimage->setExcursion($this);
        $this->excursionimages[] = $excursionimage;

        return $this;
    }

    public function removeExcursionimage(Excursionimage $excursionimage): self
    {
        if ($this->excursionimages->removeElement($excursionimage)) {
            // set the owning side to null (unless already changed)
            if ($excursionimage->getExcursion() === $this) {
                $excursionimage->setExcursion(null);
            }
        }

        return $this;
//        $this->excursionimages->removeElement($excursionimage);
//        return $this;
    }


}
