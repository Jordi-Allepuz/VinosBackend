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

    #[ORM\Column]
    private ?int $temperature = null;

    #[ORM\Column]
    private ?int $ph = null;

    #[ORM\Column]
    private ?int $alcoholContent = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sensor $idSensor = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Wine $idWine = null;

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

    public function getTemperature(): ?int
    {
        return $this->temperature;
    }

    public function setTemperature(int $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getPh(): ?int
    {
        return $this->ph;
    }

    public function setPh(int $ph): static
    {
        $this->ph = $ph;

        return $this;
    }

    public function getAlcoholContent(): ?int
    {
        return $this->alcoholContent;
    }

    public function setAlcoholContent(int $alcoholContent): static
    {
        $this->alcoholContent = $alcoholContent;

        return $this;
    }

    public function getIdSensor(): ?Sensor
    {
        return $this->idSensor;
    }

    public function setIdSensor(?Sensor $idSensor): static
    {
        $this->idSensor = $idSensor;

        return $this;
    }

    public function getIdWine(): ?Wine
    {
        return $this->idWine;
    }

    public function setIdWine(?Wine $idWine): static
    {
        $this->idWine = $idWine;

        return $this;
    }
}
