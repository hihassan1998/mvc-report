<?php

namespace App\Tests\Entity;

use App\Entity\Book;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookTest extends KernelTestCase
{
    private ?EntityManagerInterface $entityManager = null;
    private Book $book;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();

        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $schemaTool = new SchemaTool($this->entityManager);
            $schemaTool->dropSchema($metadata);
            $schemaTool->createSchema($metadata);
        }
    }

    public function testPersistAndRetrieveBook(): void
    {
        $book = new Book();
        $book->setTitle('Clean Code');
        $book->setIsbn('9780132350884');
        $book->setAuthor('Robert C. Martin');
        $book->setImage('clean-code.jpg');

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        $savedBook = $this->entityManager
            ->getRepository(Book::class)
            ->find($book->getId());

        $this->assertNotNull($savedBook);
        $this->assertEquals('Clean Code', $savedBook->getTitle());
        $this->assertEquals('9780132350884', $savedBook->getIsbn());
        $this->assertEquals('Robert C. Martin', $savedBook->getAuthor());
        $this->assertEquals('clean-code.jpg', $savedBook->getImage());

        $this->book = $book;
    }

    protected function tearDown(): void
    {
        if ($this->entityManager && isset($this->book)) {
            $bookFromDb = $this->entityManager->find(Book::class, $this->book->getId());
            if ($bookFromDb !== null) {
                $this->entityManager->remove($bookFromDb);
                $this->entityManager->flush();
            }

            $this->entityManager->close();
            $this->entityManager = null;
        }

        parent::tearDown();
    }
}
