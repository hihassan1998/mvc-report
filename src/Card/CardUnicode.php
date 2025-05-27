<?php

namespace App\Card;

/**
 * Class CardUnicode
 *
 * Provides Unicode character codes for playing cards based on their suit and value.
 */
class CardUnicode
{
    /**
     * Get the Unicode character code for a given card suit and value.
     *
     * @param string $suit  The suit of the card (e.g., "Hearts", "Clubs", "Diamonds", "Spades").
     * @param string $value The value of the card (e.g., "Ace", "2", ..., "10", "Jack", "Queen", "King").
     *
     * @return string|null The Unicode character code as an HTML entity string, or null if not found.
     */
    public static function getUnicode(string $suit, string $value): ?string
    {
        $unicodes = [
            "Hearts" => [
                "Ace" => "&#127153;",
                "2" => "&#127154;",
                "3" => "&#127155;",
                "4" => "&#127156;",
                "5" => "&#127157;",
                "6" => "&#127158;",
                "7" => "&#127159;",
                "8" => "&#127160;",
                "9" => "&#127161;",
                "10" => "&#127162;",
                "Jack" => "&#127163;",
                "Queen" => "&#127165;",
                "King" => "&#127166;"
            ],
            "Clubs" => [
                "Ace" => "&#127185;",
                "2" => "&#127186;",
                "3" => "&#127187;",
                "4" => "&#127188;",
                "5" => "&#127189;",
                "6" => "&#127190;",
                "7" => "&#127191;",
                "8" => "&#127192;",
                "9" => "&#127193;",
                "10" => "&#127194;",
                "Jack" => "&#127195;",
                "Queen" => "&#127197;",
                "King" => "&#127198;"
            ],
            "Diamonds" => [
                "Ace" => "&#127169;",
                "2" => "&#127170;",
                "3" => "&#127171;",
                "4" => "&#127172;",
                "5" => "&#127173;",
                "6" => "&#127174;",
                "7" => "&#127175;",
                "8" => "&#127176;",
                "9" => "&#127177;",
                "10" => "&#127178;",
                "Jack" => "&#127179;",
                "Queen" => "&#127181;",
                "King" => "&#127182;"
            ],
            "Spades" => [
                "Ace" => "&#127137;",
                "2" => "&#127138;",
                "3" => "&#127139;",
                "4" => "&#127140;",
                "5" => "&#127141;",
                "6" => "&#127142;",
                "7" => "&#127143;",
                "8" => "&#127144;",
                "9" => "&#127145;",
                "10" => "&#127146;",
                "Jack" => "&#127147;",
                "Queen" => "&#127149;",
                "King" => "&#127150;"
            ]
        ];

        return $unicodes[$suit][$value] ?? null;
    }
}
