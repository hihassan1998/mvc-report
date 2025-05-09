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

    public function testGetValuesReturnsArray(): void
    {
        $hand = new DiceHand();
        $hand->add(new Dice());
        $hand->roll();
        $values = $hand->getValues();

        $this->assertCount(1, $values);
        $this->assertGreaterThanOrEqual(1, $values[0]);
        $this->assertLessThanOrEqual(6, $values[0]);
    }

    public function testGetStringReturnsArray(): void
    {
        $hand = new DiceHand();
        $hand->add(new Dice());
        $hand->roll();
        $strings = $hand->getString();

        $this->assertNotEmpty($strings);
        $this->assertContainsOnly('string', $strings);
    }
}
