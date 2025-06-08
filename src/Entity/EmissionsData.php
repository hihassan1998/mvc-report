<?php

namespace App\Entity;

use App\Repository\EmissionsDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmissionsDataRepository::class)]
class EmissionsData
{
    /**
     * The unique identifier of the goal.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /** @phpstan-ignore-next-line */
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(nullable: true)]
    private ?float $emissionsSweden = null;

    #[ORM\Column(nullable: true)]
    private ?float $total = null;

    #[ORM\Column(nullable: true)]
    private ?float $emissionsAbroad = null;

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

    public function getEmissionsSweden(): ?float
    {
        return $this->emissionsSweden;
    }

    public function setEmissionsSweden(?float $emissionsSweden): static
    {
        $this->emissionsSweden = $emissionsSweden;

        return $this;
    }


    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getEmissionsAbroad(): ?float
    {
        return $this->emissionsAbroad;
    }

    public function setEmissionsAbroad(?float $emissionsAbroad): static
    {
        $this->emissionsAbroad = $emissionsAbroad;

        return $this;
    }


}
