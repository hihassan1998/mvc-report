<?php

namespace App\Card;

/**
 * Helper class for calcualtion of points in the 21 Card game.
 */
class GameHelper
{
    /**
     * Calculate the total points of a given set of cards according to Game21 rules.
     * 
     * Face cards (Jack, Queen, King) are worth 10 points.  
     * Aces are worth 14 points by default, but can be reduced to 1 if total exceeds 21.  
     * Number cards are worth their face value.
     *
     * @param Card[] $cards Array of Card objects representing the hand.
     * @return int The total point value of the hand.
     */
    public static function calculatePoints(array $cards): int
    // private function calculatePoints(array $cards): int
    {
        $points = 0;
        $aceCount = 0;

        foreach ($cards as $card) {
            $value = $card->getValue();

            if (in_array($value, ['Jack', 'Queen', 'King'])) {
                $points += 10;
            }
            if ($value == 'Ace') {
                $points += 14;
                $aceCount++;
            }
            if (!in_array($value, ['Jack', 'Queen', 'King', 'Ace'])) {
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
