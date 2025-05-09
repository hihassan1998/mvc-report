<?php

namespace App\Tests\Card;

use App\Card\Game21Service;
use App\Card\GameHelper;
use App\Card\Deck;
use App\Card\Card;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Game21ServiceTest extends TestCase
{
    /** @var \PHPUnit\Framework\MockObject\MockObject&SessionInterface */
    private SessionInterface $session;
    private Game21Service $service;

    protected function setUp(): void
    {
        $this->session = $this->createMock(SessionInterface::class);
        $helper = new GameHelper();
        $this->service = new Game21Service($helper);
    }

    public function testInitializeGame(): void
    {
        $sessionData = [];
        $this->session->expects($this->exactly(4))
            ->method('set')
            ->willReturnCallback(function (string $key, $value) use (&$sessionData) {
                $sessionData[$key] = $value;
            });

        $this->service->initializeGame($this->session);
        $this->assertArrayHasKey('deck21', $sessionData);
        $this->assertInstanceOf(Deck::class, $sessionData['deck21']);

        $this->assertSame([], $sessionData['player_cards']);
        $this->assertSame([], $sessionData['dealer_cards']);
        $this->assertFalse($sessionData['show_dealer']);
    }

    public function testPlayerHit(): void
    {
        $deck = new Deck(); // unshuffled, so first card is Hearts Ace

        $this->session->method('get')
            ->willReturnMap([
                ['deck21', null, $deck],
                ['player_cards', [], []],
                ['dealer_cards', [], []],
            ]);

        $this->session->expects($this->exactly(2))
            ->method('set');

        $result = $this->service->playerHit($this->session);

        $this->assertArrayHasKey('player_cards', $result);
        $this->assertArrayHasKey('dealer_cards', $result);
        $this->assertArrayHasKey('player_points', $result);
        $this->assertArrayHasKey('dealer_points', $result);
        $this->assertCount(1, $result['player_cards']);
    }








    public function testDealerPlays(): void
    {
        $deck = new Deck();
        $dealerCards = [new Card("Hearts", "5")];
    
        $this->session->method('get')
            ->willReturnMap([
                ['deck21', null, $deck],
                ['dealer_cards', [], $dealerCards],
            ]);
    
        $this->session->expects($this->exactly(2))
            ->method( 'set')
            ->withAnyParameters();
    
        $this->service->dealerPlays($this->session);
    
        $this->assertEquals('Hearts', $dealerCards[0]->getSuit());
        $this->assertEquals('5', $dealerCards[0]->getValue());
    }
    


    public function testDetermineResultPlayerWins(): void
    {
        $this->session->method('get')
            ->willReturnMap([
                ['player_cards', null, [new Card('Spades', '10')]],
                ['dealer_cards', null, [new Card('Diamonds', '8')]],
            ]);

        $result = $this->service->determineResult($this->session);

        $this->assertEquals('You win!', $result);
    }

    public function testDetermineResultTie(): void
    {
        $this->session->method('get')
            ->willReturnMap([
                ['player_cards', null, [new Card('♠', '9')]],
                ['dealer_cards', null, [new Card('♦', '9')]],
            ]);

        $result = $this->service->determineResult($this->session);

        $this->assertEquals("It's a tie!", $result);
    }

    public function testDetermineResultDealerWins(): void
    {
        $this->session->method('get')
            ->willReturnMap([
                ['player_cards', null, [new Card('♠', '7')]],
                ['dealer_cards', null, [new Card('♦', '9')]],
            ]);

        $result = $this->service->determineResult($this->session);

        $this->assertEquals("Dealer won, you lose!", $result);
    }
}
