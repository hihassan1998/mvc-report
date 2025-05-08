<?php

namespace App\Tests\Card;

use PHPUnit\Framework\TestCase;
use App\Card\Deck;

class DeckTest extends TestCase
{
    public function testDeckHas52Cards(): void
    {
        $deck = new Deck();
        $this->assertCount(52, $deck->getCards());
    }

    public function testDeckCanShuffle(): void
    {
        $deck = new Deck();
        $before = $deck->getCards();
        $deck->shuffle();
        $after = $deck->getCards();
        $this->assertNotEquals($before, $after, "Deck should be shuffled");
    }

    public function testDrawReducesCardCount(): void
    {
        $deck = new Deck();
        $deck->draw(5);
        $this->assertCount(47, $deck->getCards());
    }

    public function testCountReturnsCorrectNumber(): void
    {
        $deck = new Deck();
        $this->assertEquals(52, $deck->count());

        $deck->draw(2);
        $this->assertEquals(50, $deck->count());
    }

    public function testGetGroupedBySuit(): void
{
    $deck = new Deck();
    $grouped = $deck->getGroupedBySuit();

    $this->assertCount(4, $grouped);

    foreach ($grouped as $suit => $cards) {
        $this->assertCount(13, $cards, "Suit $suit should have 13 cards");
    }
}
}
