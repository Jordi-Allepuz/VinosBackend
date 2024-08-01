<?php

namespace App\Entity;

use App\Repository\MeasuringRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeasuringRepository::class)]
class Measuring
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 255)]
    private ?string $colour = null;

    #[ORM\Column(length: 255)]
    private ?string $temperature = null;

    #[ORM\Column(length: 255)]
    private ?string $alcoholContent = null;

    #[ORM\Column(length: 255)]
    private ?string $ph = null;

    #[ORM\Column]
    private ?int $idSensor = null;

    #[ORM\Column]
    private ?int $idWine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getColour(): ?string
    {
        return $this->colour;
    }

    public function setColour(string $colour): static
    {
        $this->colour = $colour;

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(string $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getAlcoholContent(): ?string
    {
        return $this->alcoholContent;
    }

    public function setAlcoholContent(string $alcoholContent): static
    {
        $this->alcoholContent = $alcoholContent;

        return $this;
    }

    public function getPh(): ?string
    {
        return $this->ph;
    }

    public function setPh(string $ph): static
    {
        $this->ph = $ph;

        return $this;
    }

    public function getIdSensor(): ?int
    {
        return $this->idSensor;
    }

    public function setIdSensor(int $idSensor): static
    {
        $this->idSensor = $idSensor;

        return $this;
    }

    public function getIdWine(): ?int
    {
        return $this->idWine;
    }

    public function setIdWine(int $idWine): static
    {
        $this->idWine = $idWine;

        return $this;
    }
}
