<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a book with title, ISBN, author, and cover image.
 *
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    /**
     * The unique identifier of the book.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /** @phpstan-ignore-next-line */
    private ?int $id = null;

    /**
     * The title of the book.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * The ISBN of the book.
     *
     * @var string|null
     */
    #[ORM\Column(length: 13)]
    private ?string $isbn = null;

    /**
     * The author of the book.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $author = null;

    /**
     * The image filename or path for the book.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    /**
     * Get the book ID.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the title of the book.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the title of the book.
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the ISBN of the book.
     */
    public function getIsbn(): ?string
    {
        return $this->isbn;
    }
    /**
     * Set the ISBN of the book.
     */
    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }
    /**
     * Get the author of the book.
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }
    /**
     * Set the author of the book.
     */
    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }
    /**
     * Get the image of the book.
     */
    public function getImage(): ?string
    {
        return $this->image;
    }
    /**
     * Set the image of the book.
     */
    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
