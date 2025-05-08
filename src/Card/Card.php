<?php

namespace App\Card;

/**
 * Class Card
 *
 * Represents a playing card with a suit and a value.
 */
class Card
{
    /**
     * @var string The suit of the card.
     */
    private string $suit;
    /**
     * @var string The value of the card.
     */
    private string $value;

    /**
     * Card constructor.
     *
     * @param string $suit  The suit of the card.
     * @param string $value The value of the card.
     */
    public function __construct(string $suit, string $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }
    /**
     * Get the suit of the card.
     *
     * @return string The suit.
     */
    public function getSuit(): string
    {
        return $this->suit;
    }
    /**
     * Get the value of the card.
     *
     * @return string The value.
     */
    public function getValue(): string
    {
        return $this->value;
    }
    /**
     * Get a string representation of the card.
     *
     * @return string A string like "King of Hearts".
     */
    public function __toString(): string
    {
        return "{$this->value} of {$this->suit}";
    }
}
