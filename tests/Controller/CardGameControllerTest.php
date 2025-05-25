<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CardGameControllerTest extends WebTestCase
{
    public function testSessionView(): void
    {
        $client = static::createClient();
        $client->request('GET', '/session');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    public function testSessionDelete(): void
    {
        $client = static::createClient();
        $client->request('GET', '/session/delete');

        $this->assertResponseRedirects('/session');
    }

    public function testCardHome(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/card');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    public function testCardDeck(): void
    {
        $client = static::createClient();
        $client->request('GET', '/card/deck');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    public function testCardShuffle(): void
    {
        $client = static::createClient();
        $client->request('GET', '/card/deck/shuffle');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    public function testDrawOne(): void
    {
        $client = static::createClient();
        $client->request('GET', '/card/deck/draw');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    public function testDrawMultiple(): void
    {
        $client = static::createClient();
        $client->request('GET', '/card/deck/draw/5');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }
}

