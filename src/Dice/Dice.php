<?php

namespace App\Dice;

/**
 * Represents a standard six-sided die.
 *
 * Allows rolling the die and retrieving its value in numeric or string format.
 */
class Dice
{
    protected ?int $value = null;

    /**
     * Initializes the die with a null value.
     */
    public function __construct()
    {
        $this->value = null;
    }
    /**
     * Rolls the die and sets a random value between 1 and 6.
     *
     * @return int The result of the roll.
     */
    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    /**
     * Returns the current value of the die.
     *
     * @return int|null The die value or null if not rolled yet.
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * Returns the value of the die as a string in square brackets.
     *
     * @return string The string representation of the die.
     */
    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
