<?php

namespace App\Card;

use App\Card\CardGraphic;

/**
 * Class Deck
 *
 * Represents a standard deck of 52 playing cards using CardGraphic objects.
 * Provides functionality to shuffle, draw cards, count remaining cards,
 * and group cards by suit.
 */
class Deck
{
    /**
     * @var CardGraphic[] Array of card objects in the deck
     */
    private array $cards = [];

    /**
     * Deck constructor.
     * Initializes a standard 52-card deck with all suits and values.
     */
    public function __construct()
    {
        $suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King', 'Ace'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new CardGraphic($suit, $value);
            }
        }
    }
    /**
     * Get all cards currently in the deck.
     *
     * @return CardGraphic[] Array of cards
     */
    public function getCards(): array
    {
        return $this->cards;
    }
    /**
     * Shuffle the cards in the deck randomly.
     *
     * @return void
     */
    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    /**
     * Draw a number of cards from the top of the deck.
     * Removes the drawn cards from the deck.
     *
     * @param int $number Number of cards to draw (default 1)
     * @return CardGraphic[] Array of drawn cards
     */
    public function draw(int $number = 1): array
    {
        return array_splice($this->cards, 0, $number);
    }

    /**
     * Get the number of cards currently in the deck.
     *
     * @return int Number of cards
     */
    public function count(): int
    {
        return count($this->cards);
    }
    /**
     * Group the cards in the deck by their suit.
     *
     * @return array<string, CardGraphic[]> Associative array with suits as keys and arrays of cards as values
     */
    public function getGroupedBySuit(): array
    {
        $grouped = [];

        foreach ($this->cards as $card) {
            $grouped[$card->getSuit()][] = $card;
        }

        return $grouped;
    }
}
