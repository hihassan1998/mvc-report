<?php

use PHPUnit\Framework\TestCase;
use App\Dice\Dice;
use App\Dice\DiceHand;

class DiceHandTest extends TestCase
{
    public function testAddIncreasesDiceCount(): void
    {
        $hand = new DiceHand();
        $hand->add(new Dice());

        $this->assertEquals(1, $hand->getNumberDices());
    }

    public function testRollDoesNotCrash(): void
    {
        $hand = new DiceHand();
        $hand->add(new Dice());
        $hand->roll();

        $this->assertTrue(true); // ensures roll() runs without error
    }

    public function testGetValuesReturnsArray(): void
    {
        $hand = new DiceHand();
        $hand->add(new Dice());
        $hand->roll();
        $values = $hand->getValues();

        $this->assertIsArray($values);
    }

    public function testGetStringReturnsArray(): void
    {
        $hand = new DiceHand();
        $hand->add(new Dice());
        $hand->roll();
        $strings = $hand->getString();

        $this->assertIsArray($strings);
    }
}
