<?php

namespace App\Entity;

use App\Repository\GoalArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoalArticleRepository::class)]
class GoalArticle
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
    private ?int $number = null;

    #[ORM\Column(length: 140)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $defination = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $article = null;

    #[ORM\Column(length: 140, nullable: true)]
    private ?string $articleTitle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDefination(): ?string
    {
        return $this->defination;
    }

    public function setDefination(string $defination): static
    {
        $this->defination = $defination;

        return $this;
    }

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(?string $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getArticleTitle(): ?string
    {
        return $this->articleTitle;
    }

    public function setArticleTitle(?string $articleTitle): static
    {
        $this->articleTitle = $articleTitle;

        return $this;
    }
}
