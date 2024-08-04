<?php

namespace App\Entity;

use App\Repository\MeasuringRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MeasuringRepository::class)]
class Measuring
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['measuring', 'wine'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['measuring', 'wine'])]
    private ?int $year = null;

    #[ORM\Column(length: 255)]
    #[Groups(['measuring', 'wine'])]
    private ?string $colour = null;

    #[ORM\Column]
    #[Groups(['measuring', 'wine'])]
    private ?int $temperature = null;

    #[ORM\Column]
    #[Groups(['measuring', 'wine'])]
    private ?int $ph = null;

    #[ORM\Column]
    #[Groups(['measuring', 'wine'])]
    private ?int $alcoholContent = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['measuring', 'wine'])]
    private ?Sensor $idSensor = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['measuring', 'wine'])]
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

    public function patch(array $data): static
    {
        if (array_key_exists('year', $data)) {
            $this->setYear($data['year']);
        }
        if (array_key_exists('colour', $data)) {
            $this->setColour($data['colour']);
        }
        if (array_key_exists('temperature', $data)) {
            $this->setTemperature($data['temperature']);
        }
        if (array_key_exists('ph', $data)) {
            $this->setPh($data['ph']);
        }
        if (array_key_exists('alcoholContent', $data)) {
            $this->setAlcoholContent($data['alcoholContent']);
        }
        if (array_key_exists('idSensor', $data)) {
            $this->setIdSensor($data['idSensor']);
        }
        if (array_key_exists('idWine', $data)) {
            $this->setIdWine($data['idWine']);
        }

        return $this;
    }
}
