<?php

namespace App\Entity;

use App\Repository\RenewableEnergyShareRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenewableEnergyShareRepository::class)]
class RenewableEnergyShare
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column]
    private ?float $heatIndustry = null;

    #[ORM\Column]
    private ?float $electricity = null;

    #[ORM\Column]
    private ?float $transport = null;

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

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getHeatIndustry(): ?float
    {
        return $this->heatIndustry;
    }

    public function setHeatIndustry(float $heatIndustry): static
    {
        $this->heatIndustry = $heatIndustry;

        return $this;
    }

    public function getElectricity(): ?float
    {
        return $this->electricity;
    }

    public function setElectricity(float $electricity): static
    {
        $this->electricity = $electricity;

        return $this;
    }

    public function getTransport(): ?float
    {
        return $this->transport;
    }

    public function setTransport(float $transport): static
    {
        $this->transport = $transport;

        return $this;
    }
}
