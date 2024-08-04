<?php

namespace App\Entity;

use App\Repository\WineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\VarDumper\Cloner\Data;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: WineRepository::class)]
class Wine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('measuring', 'wine')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('measuring', 'wine')]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups('measuring', 'wine')]
    private ?int $year = null;

    #[ORM\OneToMany(mappedBy: 'idWine', targetEntity: Measuring::class, cascade: ['persist', 'remove'])]
    #[Groups('wine', 'measuring')]
    private Collection $measurings;

    public function __construct()
    {
        $this->measurings = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getMeasurings(): Collection
    {
        return $this->measurings;
    }

    public function addMeasuring(Measuring $measuring): static
    {
        if (!$this->measurings->contains($measuring)) {
            $this->measurings->add($measuring);
            $measuring->setIdWine($this);
        }

        return $this;
    }

    public function removeMeasuring(Measuring $measuring): static
    {
        if ($this->measurings->removeElement($measuring)) {
            if ($measuring->getIdWine() === $this) {
                $measuring->setIdWine(null);
            }
        }

        return $this;
    }

    public function patch (array $data): self
    {
        if (array_key_exists('name', $data)) {
            $this->setName($data['name']);
        }
        if (array_key_exists('year', $data)) {
            $this->setYear($data['year']);
        }
        
        return $this;
    }
    
}
