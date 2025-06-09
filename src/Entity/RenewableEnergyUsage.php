<?php

namespace App\Entity;

use App\Repository\RenewableEnergyUsageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenewableEnergyUsageRepository::class)]
class RenewableEnergyUsage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?float $renewableEnergyGoal = null;

    #[ORM\Column]
    private ?float $totalRenewableEnergy = null;

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

    public function getRenewableEnergyGoal(): ?float
    {
        return $this->renewableEnergyGoal;
    }

    public function setRenewableEnergyGoal(float $renewableEnergyGoal): static
    {
        $this->renewableEnergyGoal = $renewableEnergyGoal;

        return $this;
    }

    public function getTotalRenewableEnergy(): ?float
    {
        return $this->totalRenewableEnergy;
    }

    public function setTotalRenewableEnergy(float $totalRenewableEnergy): static
    {
        $this->totalRenewableEnergy = $totalRenewableEnergy;

        return $this;
    }
}
