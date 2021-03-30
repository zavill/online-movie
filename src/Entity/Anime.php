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

    public function __construct()
    {
        $this->category = new ArrayCollection();
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

}
