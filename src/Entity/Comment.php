<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private $text;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating = 0;

    /**
     * @ORM\OneToOne(targetEntity=Anime::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $anime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSpoiler = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getAnime(): ?Anime
    {
        return $this->anime;
    }

    public function setAnime(Anime $anime): self
    {
        $this->anime = $anime;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getIsSpoiler(): ?bool
    {
        return $this->isSpoiler;
    }

    public function setIsSpoiler(bool $isSpoiler): self
    {
        $this->isSpoiler = $isSpoiler;

        return $this;
    }
}
