<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LuckyControllerTwigTest extends WebTestCase
{
    public function testHomePage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    public function testAboutPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/about');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    public function testReportPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/report');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    public function testLuckyNumberPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/lucky/number/twig');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    public function testLuckyPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/lucky');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }
}

