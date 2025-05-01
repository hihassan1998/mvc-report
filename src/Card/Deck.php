<?php

namespace App\Card;

use App\Card\CardGraphic;

class Deck
{
    /** @var CardGraphic[] */
    private array $cards = [];

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

    public function getCards(): array
    {
        return $this->cards;
    }

    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    public function draw(int $number = 1): array
    {
        return array_splice($this->cards, 0, $number);
    }

    public function count(): int
    {
        return count($this->cards);
    }
    public function getGroupedBySuit(): array
    {
        $grouped = [];

        foreach ($this->cards as $card) {
            $grouped[$card->getSuit()][] = $card;
        }

        return $grouped;
    }
}
