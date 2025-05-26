<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use App\Card\Deck;
use Doctrine\ORM\Tools\SchemaTool;
use \Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Doctrine\ORM\EntityManagerInterface;

class ApiControllerTest extends WebTestCase
{
    /**
     * @param \Symfony\Bundle\FrameworkBundle\KernelBrowser $client
     * @param array<string, mixed> $sessionData
     */
    private function setSession(KernelBrowser $client, array $sessionData = []): void
    {
        $client->request('GET', '/');

        /** @var \Symfony\Component\HttpFoundation\Session\SessionInterface $session */
        $session = $client->getRequest()->getSession();

        foreach ($sessionData as $key => $value) {
            $session->set($key, $value);
        }
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }
    private function resetDatabaseSchema(): void
    {
        /** @var EntityManagerInterface $entitym */
        $entitym = static::getContainer()->get('doctrine.orm.entity_manager');

        $schemaTool = new SchemaTool($entitym);
        $metadata = $entitym->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $schemaTool->dropSchema($metadata);
            $schemaTool->createSchema($metadata);
        }
    }


    public function testDrawCard(): void
    {
        $client = static::createClient();

        $deck = new Deck();
        $deck->shuffle();

        $this->setSession($client, ['deck' => $deck]);

        $client->request('GET', '/api/deck/draw');

        $this->assertResponseIsSuccessful();

        $content = $client->getResponse()->getContent();
        $this->assertIsString($content);

        // $json = json_decode($content, true);
        $json = json_decode($content ?: '', true);

        $this->assertIsArray($json);

        $this->assertArrayHasKey('drawn_cards', $json);
        $this->assertArrayHasKey('remaining_cards', $json);
    }


    public function testDrawNumberCards(): void
    {
        $client = static::createClient();

        $deck = new Deck();
        $deck->shuffle();

        $this->setSession($client, ['deck' => $deck]);

        $num = 3;
        $client->request('GET', "/api/deck/draw/{$num}");

        $this->assertResponseIsSuccessful();

        $content = $client->getResponse()->getContent();
        $this->assertIsString($content);

        // $json = json_decode($content, true);
        $json = json_decode($content ?: '', true);
        $this->assertIsArray($json);

        $this->assertCount($num, $json['drawn_cards']);
        $this->assertArrayHasKey('remaining_cards', $json);
    }


    public function testApiGameReturnsCorrectData(): void
    {
        $client = static::createClient();

        $deck = new Deck();
        $deck->shuffle();

        $playerCards = [$deck->draw(1)[0]];
        $dealerCards = [$deck->draw(1)[0]];

        $this->setSession($client, [
            'player_cards' => $playerCards,
            'dealer_cards' => $dealerCards,
            'show_dealer' => true
        ]);

        $client->request('GET', '/api/game');

        $this->assertResponseIsSuccessful();

        $content = $client->getResponse()->getContent();
        $this->assertIsString($content);
        $this->assertJson($content);

        // $data = json_decode($content, true);
        $data = json_decode($content ?: '', true);

        $this->assertIsArray($data);

        $this->assertArrayHasKey('player', $data);
        $this->assertArrayHasKey('dealer', $data);
        $this->assertArrayHasKey('game_over', $data);
    }

    public function testApiDeck(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/deck');

        $this->assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();
        $this->assertIsString($content);
        $this->assertJson($content);
    }

    public function testShuffleDeckStoresInSession(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/deck/shuffle');

        $session = $client->getRequest()->getSession();

        $this->assertTrue($session->has('deck'));
    }

    public function testShowAllBooksReturnsJson(): void
    {
        $client = static::createClient();

        // Ensure schema is created
        $this->resetDatabaseSchema();

        $client->request('GET', '/api/library/books');

        $this->assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();
        $this->assertIsString($content);
        $this->assertJson($content);
    }

    public function testShowBookByIsbnReturnsBookOrError(): void
    {
        $client = static::createClient();

        // Ensure schema is created
        $this->resetDatabaseSchema();

        $isbn = '12345-687-809';

        $client->request('GET', "/api/library/book/{$isbn}");

        $response = $client->getResponse();
        // $content = $response->getContent();
        $content = $response->getContent() ?: '';

        // $this->assertIsString($content, 'Response content must be a string');

        if ($response->getStatusCode() === 404) {
            $expectedJson = json_encode(['error' => 'Book not found']);
            $this->assertIsString($expectedJson, 'json_encode should return a string');

            $this->assertJsonStringEqualsJsonString(
                $expectedJson,
                $content
            );
        }
    }



}
