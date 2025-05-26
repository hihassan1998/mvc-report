<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LuckyControllerJsonTest extends WebTestCase
{
    public function testLuckyNumberJson(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/lucky/number');

        $this->assertResponseIsSuccessful();

        $content = $client->getResponse()->getContent();
        $this->assertIsString($content);

        $data = json_decode($content, true);
        $this->assertIsArray($data);

        $this->assertArrayHasKey('lucky-number', $data);
        $this->assertArrayHasKey('lucky-message', $data);
    }

    public function testQuoteJson(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/quote');

        $this->assertResponseIsSuccessful();

        $content = $client->getResponse()->getContent();
        $this->assertIsString($content);

        $data = json_decode($content, true);
        $this->assertIsArray($data);

        $this->assertArrayHasKey('quote', $data);
        $this->assertArrayHasKey('date', $data);
        $this->assertArrayHasKey('timestamp', $data);
    }
}
