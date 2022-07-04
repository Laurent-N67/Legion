<?php

namespace App\Entity;

use Assert\Range;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserMangaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Range as rang;

/**
 * @ORM\Entity(repositoryClass=UserMangaRepository::class)
 */
class UserManga
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @rang(min = 1,
     *      max = 10,
     *      minMessage = "La note doit être d'au moins 1 points",
     *      maxMessage = "La note ne peu excéder les 10 points"
     * )
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=Manga::class, inversedBy="userMangas")
     */
    private $manga;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="userMangas")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getManga(): ?Manga
    {
        return $this->manga;
    }

    public function setManga(?Manga $manga): self
    {
        $this->manga = $manga;

        return $this;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(?Utilisateur $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAverageNote(){
        $answer =$this-> getNote('SELECT note ,AVG(note) AS avg_note FROM user_manga');
        return $answer;
    }

}
