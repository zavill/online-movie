<?php

namespace App\Entity;

use App\Repository\ScreenshotRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScreenshotRepository::class)
 */
class Screenshot
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
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=Anime::class, inversedBy="screenshots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Anime;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
