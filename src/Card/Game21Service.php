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
        /** @var Deck $deck */
        $deck = new Deck();
        $deck->shuffle();

        $playerCards = $deck->draw(0);
        $dealerCards = $deck->draw(0);

        $session->set('deck21', $deck);
        $session->set('player_cards', $playerCards);
        $session->set('dealer_cards', $dealerCards);
        $session->set('show_dealer', false);
    }

    /**
     * Draws a card for the player and updates session state.
     *
     * @param SessionInterface $session
     *
     * @return array{
     *     player_cards: \App\Card\Card[],
     *     dealer_cards: \App\Card\Card[],
     *     player_points: int,
     *     dealer_points: int
     * }
     */
    public function playerHit(SessionInterface $session): array
    {
        /** @var Deck $deck */
        $deck = $session->get('deck21');
        $playerCards = (array) $session->get('player_cards', []);
        /** @var Card[] $dealerCards */
        $dealerCards = (array) $session->get('dealer_cards', []);

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
        /** @var Card[] $dealerCards */
        $dealerCards = $session->get('dealer_cards', []);

        while ($this->getPoints($dealerCards) < 17) {
            $dealerCards[] = $deck->draw(1)[0];
        }

        $session->set('dealer_cards', $dealerCards);
        $session->set('show_dealer', true);
    }

    /**
     * Determine the result of the game based on points.
     *
     * @return string
     */

    public function determineResult(SessionInterface $session): string
    {
        /** @var Card[] $playerCards */
        $playerCards = (array) $session->get('player_cards');
        /** @var Card[] $dealerCards */
        $dealerCards = (array) $session->get('dealer_cards');

        $playerPoints = $this->getPoints($playerCards);
        $dealerPoints = $this->getPoints($dealerCards);

        if ($dealerPoints > 21 || $playerPoints > $dealerPoints) {
            return 'You win!';
        } elseif ($playerPoints === $dealerPoints) {
            return 'It\'s a tie!';
        }
        return 'Dealer won, you lose!';
    }

    /**
     * Gets the calculated points.
     *
     * @param Card[] $cards
     * @return int
     */
    public function getPoints($cards): int
    {
        return $this->helper->calculatePoints($cards);
    }
}
