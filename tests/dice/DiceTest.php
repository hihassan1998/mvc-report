<?php
use PHPUnit\Framework\TestCase;
use App\Dice\Dice;

class DiceTest extends TestCase
{
    public function testRollReturnsValueBetween1And6(): void
    {
        $dice = new Dice();
        $value = $dice->roll();

        $this->assertGreaterThanOrEqual(1, $value);
        $this->assertLessThanOrEqual(6, $value);
    }

    public function testGetValueReturnsRolledValue(): void
    {
        $dice = new Dice();
        $rolled = $dice->roll();

        $this->assertSame($rolled, $dice->getValue());
    }

   
}
