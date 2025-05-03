<?php

namespace App\Card;

class GameHelper
{
    public static function calculatePoints(array $cards): int
    // private function calculatePoints(array $cards): int
    {
        $points = 0;
        $aceCount = 0;

        foreach ($cards as $card) {
            $value = $card->getValue();

            if (in_array($value, ['Jack', 'Queen', 'King'])) {
                $points += 10;
            } elseif ($value == 'Ace') {
                $points += 14;
                $aceCount++;
            } else {
                $points += (int) $value;
            }
        }

        // if the points exceed 21, convert Aces from 14 to 1
        while ($points > 21 && $aceCount > 0) {
            $points -= 13;
            $aceCount--;
        }

        return $points;
    }
}
