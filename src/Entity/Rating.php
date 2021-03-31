<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 */
class Rating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $ratingValue;

    /**
     * @ORM\ManyToOne(targetEntity=Anime::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Anime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRatingValue(): ?int
    {
        return $this->ratingValue;
    }

    public function setRatingValue(int $ratingValue): self
    {
        $this->ratingValue = $ratingValue;

        return $this;
    }

    public function getAnime(): ?Anime
    {
        return $this->Anime;
    }

    public function setAnime(?Anime $Anime): self
    {
        $this->Anime = $Anime;

        return $this;
    }
}
