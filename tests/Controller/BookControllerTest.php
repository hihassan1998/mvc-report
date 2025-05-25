<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;

class BookControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/book');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello BookController! ✅');
    }

    public function testCreateProduct(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/book/create');

        $this->assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();
        $this->assertIsString($content);
        $this->assertStringContainsString('Three books added successfully.', $content);
    }

    public function testViewAllProducts(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('li');

    }

    public function testShowBookById(): void
    {
        $client = static::createClient();

        // We first need to have a book in DB to test
        $container = static::getContainer();
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);

        $book = new Book();
        $book->setTitle('Test Book');
        $book->setIsbn('1234567890');
        $book->setAuthor('Test Author');
        $book->setImage('test.jpg');

        $em->persist($book);
        $em->flush();

        $client->request('GET', '/book/show/' . $book->getId());

        $this->assertResponseIsSuccessful();
        $json = $client->getResponse()->getContent();
        $this->assertIsString($json);
        $responseData = json_decode($json, true);
        $this->assertIsArray($responseData);


        $this->assertEquals('Test Book', $responseData['title']);
        $this->assertEquals('1234567890', $responseData['isbn']);
        $this->assertEquals('Test Author', $responseData['author']);
        $this->assertEquals('test.jpg', $responseData['image']);
    }

    public function testNewBookFormDisplays(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/book/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }
    public function testNewBookSubmit(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/library/book/new');

        $form = $crawler->selectButton('Save')->form();
        $form['book_type_form[title]'] = 'New Book';
        $form['book_type_form[isbn]'] = '111-222-333';
        $form['book_type_form[author]'] = 'Author';
        $form['book_type_form[image]'] = 'image.jpg';

        $client->submit($form);
        $client->followRedirect();

        $this->assertRouteSame('book_view_all');
    }

    public function testMetrics(): void
    {
        $client = static::createClient();
        $client->request('GET', '/metrics');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Analys');
    }

}
