<?php

namespace App\Entity;

use App\Repository\MeasurementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MeasurementRepository::class)]
class Measurement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'measurements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message: 'Data jest wymagana.', groups: ['new', 'edit'])]
    private ?\DateTime $date = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Temperatura jest wymagana.', groups: ['new', 'edit'])]
    #[Assert\Range(min: -100, max: 100, notInRangeMessage: 'Temperatura musi być pomiędzy {{ min }} a {{ max }}.', groups: ['new', 'edit'])]
    private ?int $celsius = null;

    #[ORM\Column]
    private ?int $wind = null;

    #[ORM\Column]
    private ?int $rainfall = null;

    #[ORM\Column]
    private ?int $pressure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCelsius(): ?int
    {
        return $this->celsius;
    }

    public function setCelsius(int $celsius): static
    {
        $this->celsius = $celsius;

        return $this;
    }

    public function getWind(): ?int
    {
        return $this->wind;
    }

    public function setWind(int $wind): static
    {
        $this->wind = $wind;

        return $this;
    }

    public function getRainfall(): ?int
    {
        return $this->rainfall;
    }

    public function setRainfall(int $rainfall): static
    {
        $this->rainfall = $rainfall;

        return $this;
    }

    public function getPressure(): ?int
    {
        return $this->pressure;
    }

    public function setPressure(int $pressure): static
    {
        $this->pressure = $pressure;

        return $this;
    }
}
