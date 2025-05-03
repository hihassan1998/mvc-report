<?php

namespace App\Card;

use App\Card\Deck;
use App\Card\GameHelper;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Game21Service
{
    private GameHelper $helper;

    public function __construct(GameHelper $helper)
    {
        $this->helper = $helper;
    }

    public function initializeGame(SessionInterface $session): void
    {
        $deck = new Deck();
        $deck->shuffle();

        $playerCards = $deck->draw(0);
        $dealerCards = $deck->draw(0);

        $session->set('deck21', $deck);
        $session->set('player_cards', $playerCards);
        $session->set('dealer_cards', $dealerCards);
        $session->set('show_dealer', false);
    }

    public function playerHit(SessionInterface $session): array
    {
        /** @var Deck $deck */
        $deck = $session->get('deck21');
        $playerCards = $session->get('player_cards', []);
        $dealerCards = $session->get('dealer_cards', []);

        $playerCards[] = $deck->draw(1)[0];

        $session->set('player_cards', $playerCards);
        $session->set('deck21', $deck);

        return [
            'player_cards' => $playerCards,
            'dealer_cards' => $dealerCards,
            'player_points' => $this->getPoints($playerCards),
            'dealer_points' => $this->getPoints($dealerCards),
        ];
    }

    public function dealerPlays(SessionInterface $session): void
    {
        /** @var Deck $deck */
        $deck = $session->get('deck21');
        $dealerCards = $session->get('dealer_cards', []);

        while ($this->getPoints($dealerCards) < 17) {
            $dealerCards[] = $deck->draw(1)[0];
        }

        $session->set('dealer_cards', $dealerCards);
        $session->set('show_dealer', true);
    }

    public function determineResult(SessionInterface $session): string
    {
        $playerCards = $session->get('player_cards');
        $dealerCards = $session->get('dealer_cards');

        $playerPoints = $this->getPoints($playerCards);
        $dealerPoints = $this->getPoints($dealerCards);

        if ($dealerPoints > 21 || $playerPoints > $dealerPoints) {
            return 'You win!';
        } elseif ($playerPoints === $dealerPoints) {
            return 'It\'s a tie!';
        }
        return 'Dealer won, you lose!';
    }

    public function getPoints(array $cards): int
    {
        return $this->helper->calculatePoints($cards);
    }
}
