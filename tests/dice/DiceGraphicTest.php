<?php

use PHPUnit\Framework\TestCase;
use App\Dice\DiceGraphic;

class DiceGraphicTest extends TestCase
{
    public function testGetAsStringReturnsUnicodeCharacter(): void
    {
        $dice = new DiceGraphic();
        $value = $dice->roll();
        $result = $dice->getAsString();

        $unicodeFaces = ['⚀', '⚁', '⚂', '⚃', '⚄', '⚅'];

        $this->assertContains($result, $unicodeFaces);
        $this->assertSame($unicodeFaces[$value - 1], $result);
    }
}
