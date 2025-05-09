<?php

use PHPUnit\Framework\TestCase;
use App\Card\Card;

class CardTest extends TestCase
{
    public function testCardProperties(): void
    {
        $card = new Card('Hearts', 'King');

        $this->assertEquals('Hearts', $card->getSuit());
        $this->assertEquals('King', $card->getValue());
    }

    public function testToString(): void
    {
        $card = new Card('Spades', 'Ace');
        $this->assertEquals('Ace of Spades', (string) $card);
    }
}
