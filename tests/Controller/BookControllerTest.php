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


    public function testNewBookFormDisplays(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/book/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }


    public function testMetrics(): void
    {
        $client = static::createClient();
        $client->request('GET', '/metrics');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Analys');
    }

}
