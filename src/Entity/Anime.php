<?php

namespace App\Entity;

use App\Repository\AnimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Webmozart\Assert\Assert;

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

    public function getKinopoiskID(): ?string
    {
        return $this->kinopoiskID;
    }

    public function setKinopoiskID(string $kinopoiskID): self
    {
        $this->kinopoiskID = $kinopoiskID;

        return $this;
    }

    public function getImdbID(): ?string
    {
        return $this->imdbID;
    }

    public function setImdbID(string $imdbID): self
    {
        $this->imdbID = $imdbID;

        return $this;
    }

    public function getMdlID(): ?string
    {
        return $this->mdlID;
    }

    public function setMdlID(string $mdlID): self
    {
        $this->mdlID = $mdlID;

        return $this;
    }

    public function getShikimoriID(): ?string
    {
        return $this->shikimoriID;
    }

    public function setShikimoriID(string $shikimoriID): self
    {
        $this->shikimoriID = $shikimoriID;

        return $this;
    }

    public function getWorldartanimeID(): ?string
    {
        return $this->worldartanimeID;
    }

    public function setWorldartanimeID(string $worldartanimeID): self
    {
        $this->worldartanimeID = $worldartanimeID;

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

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    /**
     * @return Collection|Categories[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

}
