<?php

namespace App\Entity;

use App\Repository\MarsPhotosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarsPhotosRepository::class)
 */
class MarsPhotos implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $sol;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $camera;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="date")
     */
    private $earthDate;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private $rover;

    /**
     * @ORM\Column(type="integer")
     */
    private $nasaid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSol(): ?int
    {
        return $this->sol;
    }

    public function setSol(int $sol): self
    {
        $this->sol = $sol;

        return $this;
    }

    public function getCamera(): ?string
    {
        return $this->camera;
    }

    public function setCamera(string $camera): self
    {
        $this->camera = $camera;

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

    public function getEarthDate(): ?\DateTimeInterface
    {
        return $this->earthDate;
    }

    public function setEarthDate(\DateTimeInterface $earthDate): self
    {
        $this->earthDate = $earthDate;

        return $this;
    }

    public function getRover(): ?string
    {
        return $this->rover;
    }

    public function setRover(string $rover): self
    {
        $this->rover = $rover;

        return $this;
    }

    public function getNasaid(): ?int
    {
        return $this->nasaid;
    }

    public function setNasaid(int $nasaid): self
    {
        $this->nasaid = $nasaid;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'url' => $this->url,
            'earthDate' => $this->earthDate,
            'rover' => $this->rover,
            'camera' => $this->camera,
        ];
    }


}
