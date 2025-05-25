<?php

namespace App\Card;

class CardGraphic extends Card implements \JsonSerializable
{
    public function __construct(string $suit, string $value)
    {
        parent::__construct($suit, $value);
    }
    public function getGraphic(): string
    {
        return CardUnicode::getUnicode($this->getSuit(), $this->getValue()) ?? '';
    }


    public function __toString(): string
    {
        return $this->getValue() . ' of ' . $this->getSuit();
    }

    public function getColorClass(): string
    {
        return in_array($this->getSuit(), ['Hearts', 'Diamonds']) ? 'red-card' : '';
    }


    public function jsonSerialize(): mixed
    {
        return [
            'suit' => $this->getSuit(),
            'value' => $this->getValue(),
            'graphic' => $this->getGraphic()
        ];
    }
}
