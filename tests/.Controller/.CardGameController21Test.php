<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CardGameController21Test extends WebTestCase
{
    public function testRoutes(): void
    {
        $client = static::createClient();

        $client->request('GET', '/21game/card');
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/game/doc');
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/21card/start');
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/game21/hit');
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/card21/stand');
        $this->assertResponseRedirects('/21card/start');

        $client->request('GET', '/card21/end_game');
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/card21/reset');
        $this->assertResponseRedirects('/21card/start');
    }
}
