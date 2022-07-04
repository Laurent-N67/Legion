<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuteurRepository::class)
 */
class Auteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $NomAuteur;

    /**
     * @ORM\Column(type="text",length=500, nullable=true)
     */
    private $Biographie;

    /**
     * @ORM\OneToMany(targetEntity=Manga::class, mappedBy="auteur", orphanRemoval=true)
     */
    private $mangas;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $prenomAuteur;

    public function __construct()
    {
        $this->mangas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAuteur(): ?string
    {
        return $this->NomAuteur;
    }

    public function setNomAuteur(string $NomAuteur): self
    {
        $this->NomAuteur = $NomAuteur;

        return $this;
    }

    public function getBiographie(): ?string
    {
        return $this->Biographie;
    }

    public function setBiographie(?string $Biographie): self
    {
        $this->Biographie = $Biographie;

        return $this;
    }

    /**
     * @return Collection<int, Manga>
     */
    public function getMangas(): Collection
    {
        return $this->mangas;
    }

    public function addManga(Manga $manga): self
    {
        if (!$this->mangas->contains($manga)) {
            $this->mangas[] = $manga;
            $manga->setAuteur($this);
        }

        return $this;
    }

    public function removeManga(Manga $manga): self
    {
        if ($this->mangas->removeElement($manga)) {
            // set the owning side to null (unless already changed)
            if ($manga->getAuteur() === $this) {
                $manga->setAuteur(null);
            }
        }

        return $this;
    }

    public function getPrenomAuteur(): ?string
    {
        return $this->prenomAuteur;
    }

    public function setPrenomAuteur(?string $prenomAuteur): self
    {
        $this->prenomAuteur = $prenomAuteur;

        return $this;
    }
    public function __toString()
    {
        return $this -> NomAuteur." ".$this->prenomAuteur;
    }
}
