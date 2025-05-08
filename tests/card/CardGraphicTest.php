<?php

namespace App\Tests\Card;

use PHPUnit\Framework\TestCase;
use App\Card\CardGraphic;

class CardGraphicTest extends TestCase
{
    public function testCardGraphicCreation(): void
    {
        $card = new CardGraphic('Hearts', 'Ace');
        $this->assertEquals('Hearts', $card->getSuit());
        $this->assertEquals('Ace', $card->getValue());
        $this->assertEquals('Ace of Hearts', (string) $card);
    }

    public function testGetGraphicReturnsUnicode(): void
    {
        $card = new CardGraphic('Spades', 'King');
        $unicode = $card->getGraphic();
        $this->assertIsString($unicode);
        $this->assertStringContainsString('#', $unicode);
    }

    public function testGetColorClass(): void
    {
        $redCard = new CardGraphic('Diamonds', '2');
        $blackCard = new CardGraphic('Spades', '2');

        $this->assertEquals('red-card', $redCard->getColorClass());
        $this->assertEquals('', $blackCard->getColorClass());
    }

    public function testJsonSerialize(): void
    {
        $card = new CardGraphic('Clubs', '10');
        $json = $card->jsonSerialize();

        $this->assertIsArray($json);
        $this->assertEquals('Clubs', $json['suit']);
        $this->assertEquals('10', $json['value']);
        $this->assertEquals($card->getGraphic(), $json['graphic']);
    }
}
