<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MangaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=MangaRepository::class)
 */
class Manga
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $Titre;

    /**
     * @ORM\Column(type="text",length=500, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=Chapitre::class, mappedBy="manga", orphanRemoval=true)
     */
    private $chapitre;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="mangas")
     */
    private $tag;

    /**
     * @ORM\ManyToOne(targetEntity=Auteur::class, inversedBy="mangas")
     */
    private $auteur;

    /**
     * @ORM\Column(type="text")
     */
    private $garde;

    /**
     * @ORM\OneToMany(targetEntity=UserManga::class, mappedBy="manga", orphanRemoval=true)
     */
    private $userMangas;

    public function __construct()
    {
        $this->chapitre = new ArrayCollection();
        $this->tag = new ArrayCollection();
        $this->userMangas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function isStatut()
    {
        $result = "";
        switch($this->statut) {
            case 0: $result = "Terminé"; break;
            case 1: $result = "En cours"; break;
        }
        return $result;
    }

    public function setStatut($statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, Chapitre>
     */
    public function getChapitre(): Collection
    {
        return $this->chapitre;
    }

    public function addChapitre(Chapitre $chapitre): self
    {
        if (!$this->chapitre->contains($chapitre)) {
            $this->chapitre[] = $chapitre;
            $chapitre->setManga($this);
        }

        return $this;
    }

    public function removeChapitre(Chapitre $chapitre): self
    {
        if ($this->chapitre->removeElement($chapitre)) {
            // set the owning side to null (unless already changed)
            if ($chapitre->getManga() === $this) {
                $chapitre->setManga(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

        return $this;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function __toString()
    {
        return $this->Titre;
    }

    public function getGarde(): ?string
    {
        return $this->garde;
    }

    public function setGarde(string $garde): self
    {
        $this->garde = $garde;

        return $this;
    }

    /**
     * @return Collection<int, UserManga>
     */
    public function getUserMangas(): Collection
    {
        return $this->userMangas;
    }

    public function addUserManga(UserManga $userManga): self
    {
        if (!$this->userMangas->contains($userManga)) {
            $this->userMangas[] = $userManga;
            $userManga->setManga($this);
        }

        return $this;
    }

    public function removeUserManga(UserManga $userManga): self
    {
        if ($this->userMangas->removeElement($userManga)) {
            // set the owning side to null (unless already changed)
            if ($userManga->getManga() === $this) {
                $userManga->setManga(null);
            }
        }

        return $this;
    }

    public function getAverageNote()
    {
        $notes = $this->getUserMangas();
        $totalNote = 0;
        $totalVote = 0;
        $totalNote = 0;
        foreach ($notes as $note) {
            $totalNote += $note->getNote();
            $totalVote +=1;
        }
        if ($totalVote === 0) {
            return "n/a ";
        }
        $totalNote = $totalNote/$totalVote;
        return $totalNote; "/10";
    }
}
