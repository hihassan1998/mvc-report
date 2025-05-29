<?php

namespace App\Dice;

use App\Dice\Dice;

/**
 * Represents a hand of dice.
 *
 * Provides functionality to add dice, roll them, and retrieve their values.
 */
class DiceHand
{
    /** @var Dice[] An array holding the dice in the hand */
    private array $hand = [];
    /**
     * Adds a die to the hand.
     *
     * @param Dice $die The die to add.
     */
    public function add(Dice $die): void
    {
        $this->hand[] = $die;
    }
    /**
     * Rolls all dice in the hand.
     *
     * @return void
     */
    public function roll(): void
    {
        foreach ($this->hand as $die) {
            $die->roll();
        }
    }
    /**
     * Returns the number of dice in the hand.
     *
     * @return int The count of dice.
     */
    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    /**
     * Returns the numeric values of all dice in the hand.
     *
     * @return (int|null)[] An array of dice values.
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getValue();
        }
        return $values;
    }
    /**
     * Returns the string or graphical representations of all dice.
     *
     * @return string[] An array of die strings (e.g., "[3]" or "⚂").
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getAsString();
        }
        return $values;
    }
}
