<?php

namespace App\Tests\Entity;

use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testBookProperties(): void
    {
        $book = new Book();

        $title = 'Harry Potter';
        $isbn = '9783161484100';
        $author = 'J.K. Rowling';
        $image = 'harry_potter.jpg';

        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setImage($image);

        $this->assertSame($title, $book->getTitle());
        $this->assertSame($isbn, $book->getIsbn());
        $this->assertSame($author, $book->getAuthor());
        $this->assertSame($image, $book->getImage());

        $this->assertNull($book->getId());
    }
}
