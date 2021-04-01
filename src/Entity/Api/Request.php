<?php

namespace App\Entity\Api;

use App\Repository\Api\RequestRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestRepository::class)
 */
class Request
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=129)
     */
    private $userIP;

    /**
     * @ORM\Column(type="datetime")
     */
    private $sendDate;

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

    public function getUserIP(): ?string
    {
        return $this->userIP;
    }

    public function setUserIP(string $userIP): self
    {
        $this->userIP = $userIP;

        return $this;
    }

    public function getSendDate(): ?DateTimeInterface
    {
        return $this->sendDate;
    }

    public function setSendDate(DateTimeInterface $sendDate): self
    {
        $this->sendDate = $sendDate;

        return $this;
    }
}
