<?php

namespace App\Entity;

use App\Repository\AnimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimeRepository::class)
 */
class Anime
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameOrig;

    /**
     * @ORM\ManyToMany(targetEntity=Categories::class, inversedBy="animes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $kodikId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=4096, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $posterURL;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $kinopoiskID;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $imdbID;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $mdlID;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $shikimoriID;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $worldartanimeID;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $views = 0;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $episodes;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $ageCensor;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $episodeLength;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $voiced;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $timings;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $studio;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="Anime")
     */
    private $ratings;

    /**
     * @ORM\Column(type="float")
     */
    private $averageRating = 0.0;

    /**
     * @ORM\OneToMany(targetEntity=Screenshot::class, mappedBy="Anime")
     */
    private $screenshots;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="Anime")
     */
    private $comments;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->screenshots = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNameOrig(): ?string
    {
        return $this->nameOrig;
    }

    public function setNameOrig(?string $nameOrig): self
    {
        $this->nameOrig = $nameOrig;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getKodikId(): ?string
    {
        return $this->kodikId;
    }

    public function setKodikId(string $kodikId): self
    {
        $this->kodikId = $kodikId;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getPosterURL(): ?string
    {
        return $this->posterURL;
    }

    public function setPosterURL(string $posterURL): self
    {
        $this->posterURL = $posterURL;

        return $this;
    }

    public function getKinopoiskID(): ?string
    {
        return $this->kinopoiskID;
    }

    public function setKinopoiskID(?string $kinopoiskID): self
    {
        $this->kinopoiskID = $kinopoiskID;

        return $this;
    }

    public function getImdbID(): ?string
    {
        return $this->imdbID;
    }

    public function setImdbID(?string $imdbID): self
    {
        $this->imdbID = $imdbID;

        return $this;
    }

    public function getMdlID(): ?string
    {
        return $this->mdlID;
    }

    public function setMdlID(?string $mdlID): self
    {
        $this->mdlID = $mdlID;

        return $this;
    }

    public function getShikimoriID(): ?string
    {
        return $this->shikimoriID;
    }

    public function setShikimoriID(?string $shikimoriID): self
    {
        $this->shikimoriID = $shikimoriID;

        return $this;
    }

    public function getWorldartanimeID(): ?string
    {
        return $this->worldartanimeID;
    }

    public function setWorldartanimeID(?string $worldartanimeID): self
    {
        $this->worldartanimeID = $worldartanimeID;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(?int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEpisodes(): ?string
    {
        return $this->episodes;
    }

    public function setEpisodes(?string $episodes): self
    {
        $this->episodes = $episodes;

        return $this;
    }

    public function getAgeCensor(): ?string
    {
        return $this->ageCensor;
    }

    public function setAgeCensor(?string $ageCensor): self
    {
        $this->ageCensor = $ageCensor;

        return $this;
    }

    public function getEpisodeLength(): ?string
    {
        return $this->episodeLength;
    }

    public function setEpisodeLength(?string $episodeLength): self
    {
        $this->episodeLength = $episodeLength;

        return $this;
    }

    public function getVoiced(): ?string
    {
        return $this->voiced;
    }

    public function setVoiced(?string $voiced): self
    {
        $this->voiced = $voiced;

        return $this;
    }

    public function getTimings(): ?string
    {
        return $this->timings;
    }

    public function setTimings(?string $timings): self
    {
        $this->timings = $timings;

        return $this;
    }

    /**
     * @return Collection|Categories[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getIdList(): ?array
    {
        return [
            'kinopoiskID' => $this->kinopoiskID,
            'imdbID' => $this->imdbID,
            'mdlID' => $this->mdlID,
            'shikimoriID' => $this->shikimoriID,
            'worldartanimeID' => $this->worldartanimeID,
        ];
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStudio(): ?string
    {
        return $this->studio;
    }

    public function setStudio(?string $studio): self
    {
        $this->studio = $studio;

        return $this;
    }

    public function addView(): self
    {
        $this->views++;

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setAnime($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getAnime() === $this) {
                $rating->setAnime(null);
            }
        }

        return $this;
    }

    public function getAverageRating(): ?float
    {
        return $this->averageRating;
    }

    public function setAverageRating(float $averageRating): self
    {
        $this->averageRating = $averageRating;

        return $this;
    }

    /**
     * @return Collection|Screenshot[]
     */
    public function getScreenshots(): Collection
    {
        return $this->screenshots;
    }

    public function addScreenshot(Screenshot $screenshot): self
    {
        if (!$this->screenshots->contains($screenshot)) {
            $this->screenshots[] = $screenshot;
            $screenshot->setAnime($this);
        }

        return $this;
    }

    public function removeScreenshot(Screenshot $screenshot): self
    {
        if ($this->screenshots->removeElement($screenshot)) {
            // set the owning side to null (unless already changed)
            if ($screenshot->getAnime() === $this) {
                $screenshot->setAnime(null);
            }
        }

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->setUpdatedAt(new \DateTime('now'));
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    public function jsonSerialize(): array
    {

        foreach ($this->getCategory() as $category) {
            $categories[] = $category->getName();
        }

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'nameOrig' => $this->getNameOrig(),
            'categories' => $categories ?? [],
            'averageRating' => $this->getAverageRating(),
            'posterURL' => $this->getPosterURL(),
            'type' => $this->getType(),
            'year' => $this->getYear(),
            'shortDescription' => $this->getShortDescription()
        ];
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAnime($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAnime() === $this) {
                $comment->setAnime(null);
            }
        }

        return $this;
    }

}
