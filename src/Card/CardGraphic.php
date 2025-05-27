<?php

namespace App\Card;

/**
 * Class CardGraphic
 *
 * Represents a playing card with graphical Unicode representation.
 * Extends the base Card class and implements JsonSerializable interface.
 */
class CardGraphic extends Card implements \JsonSerializable
{
    /**
     * CardGraphic constructor.
     *
     * @param string $suit  The suit of the card (e.g., Hearts, Diamonds).
     * @param string $value The value of the card (e.g., Ace, 2, King).
     */
    public function __construct(string $suit, string $value)
    {
        parent::__construct($suit, $value);
    }
    /**
     * Get the Unicode graphic representation of the card.
     *
     * @return string Unicode character representing the card, or empty string if not available.
     */
    public function getGraphic(): string
    {
        return CardUnicode::getUnicode($this->getSuit(), $this->getValue()) ?? '';
    }

    /**
     * String representation of the card.
     *
     * @return string Human-readable string like "Ace of Hearts".
     */
    public function __toString(): string
    {
        return $this->getValue() . ' of ' . $this->getSuit();
    }

    /**
     * Get CSS class representing the card color.
     *
     * @return string Returns 'red-card' if suit is Hearts or Diamonds; otherwise, empty string.
     */
    public function getColorClass(): string
    {
        return in_array($this->getSuit(), ['Hearts', 'Diamonds']) ? 'red-card' : '';
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @return array{
     *     suit: string,
     *     value: string,
     *     graphic: string
     * }
     */
    public function jsonSerialize(): mixed
    {
        return [
            'suit' => $this->getSuit(),
            'value' => $this->getValue(),
            'graphic' => $this->getGraphic()
        ];
    }
}
