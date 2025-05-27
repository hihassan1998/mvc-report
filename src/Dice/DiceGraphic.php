<?php

namespace App\Dice;

/**
 * A graphical die that returns Unicode symbols instead of numbers.
 *
 * Extends Dice to provide visual representation using Unicode characters ⚀–⚅.
 */
class DiceGraphic extends Dice
{
    /** @var string[] */
    private array $representation = [
        '⚀',
        '⚁',
        '⚂',
        '⚃',
        '⚄',
        '⚅',
    ];

    /**
     * Calls the parent constructor to initialize the die.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns the die face as a Unicode character based on the current value.
     *
     * @return string The graphical representation of the die.
     */
    public function getAsString(): string
    {
        return $this->representation[$this->value - 1];
    }
}
