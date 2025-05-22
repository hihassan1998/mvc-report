<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    public function testViewAllBooksRoute(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('table');
    }

    public function testNonExistingBookReturns404(): void
    {
        $client = static::createClient();
        $client->request('GET', '/library/book/view/999999');

        $this->assertResponseStatusCodeSame(404);
    }
}
