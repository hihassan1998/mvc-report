<?php

namespace App\Controller;

use App\Card\Deck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController21 extends AbstractController
{
    #[Route("/21game/card", name: "21card_start")]
    public function home(): Response
    {
        return $this->render('card21/home.html.twig');
    }

    private function calculatePoints(array $cards): int
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

    #[Route("/21card/start", name: "game21_start")]
    public function startGame(SessionInterface $session): Response
    {
        $playerCards = $session->get('player_cards', []);
        $dealerCards = $session->get('dealer_cards', []);
        $showDealer = (bool) $session->get('show_dealer', false);

        // If show_dealer is false, deal new cards and shuffle the deck
        if (!$showDealer) {
            $deck = new Deck();
            $deck->shuffle();
            $session->set('deck21', $deck);

            // Draw cards for both the player and dealer
            $playerCards = $deck->draw(0);
            $dealerCards = $deck->draw(0);

            // Store in session
            $session->set('player_cards', $playerCards);
            $session->set('dealer_cards', $dealerCards);
        }

        return $this->render('card21/start.html.twig', [
            'player_cards' => $playerCards,
            'dealer_cards' => $dealerCards,
            'player_points' => $this->calculatePoints($playerCards),
            'dealer_points' => $this->calculatePoints($dealerCards),
            'show_dealer' => $showDealer,
        ]);
    }
    #[Route("/game21/hit", name: "game21_hit")]
    public function hit(SessionInterface $session): Response
    {
        /** @var Deck $deck */
        $deck = $session->get('deck21');
        $playerCards = $session->get('player_cards', []);
        $dealerCards = $session->get('dealer_cards', []);
        $showDealer = (bool) $session->get('show_dealer', false);

        $newCard = $deck->draw(1)[0];
        $playerCards[] = $newCard;

        $session->set('deck21', $deck);
        $session->set('player_cards', $playerCards);

        // Calculate points
        $playerPoints = $this->calculatePoints($playerCards);
        $dealerPoints = $this->calculatePoints($dealerCards);

        // If player busts end the game route
        if ($playerPoints > 21) {
            return $this->render('card21/end_game.html.twig', [
                'message' => 'You busted!',
                'player_cards' => $playerCards,
                'player_points' => $playerPoints,
                'dealer_cards' => $dealerCards,
                'dealer_points' => $dealerPoints,
                'show_dealer' => $showDealer,
            ]);
        }

        // NOrmal flow of game
        return $this->render('card21/start.html.twig', [
            'player_cards' => $playerCards,
            'player_points' => $playerPoints,
            'dealer_cards' => $dealerCards,
            'dealer_points' => $dealerPoints,
            'show_dealer' => $showDealer,
        ]);
    }

    #[Route("/card21/stand", name: "game21_stand")]
    public function stand(SessionInterface $session): Response
    {
        $deck = $session->get('deck21');
        $dealerCards = $session->get('dealer_cards');

        // until reaching 17 or more points
        while ($this->calculatePoints($dealerCards) < 17) {
            $dealerCards[] = $deck->draw(1)[0];
        }

        $session->set('dealer_cards', $dealerCards);
        $session->set('show_dealer', true);

        return $this->redirectToRoute('game21_start');
    }
    #[Route("/card21/end_game", name: "game21_end_game")]
    public function endGame(SessionInterface $session): Response
    {
        $playerCards = $session->get('player_cards');
        $dealerCards = $session->get('dealer_cards');
        $playerPoints = $this->calculatePoints($playerCards);
        $dealerPoints = $this->calculatePoints($dealerCards);

        if ($dealerPoints > 21 || $playerPoints > $dealerPoints) {
            $result = 'You win!';
        } elseif ($dealerPoints == $playerPoints) {
            $result = 'It\'s a tie!';
        } else {
            $result = 'Dealer won, you lose!';
        }

        return $this->render('card21/end_game.html.twig', [
            'result' => $result,
            'player_cards' => $playerCards,
            'player_points' => $playerPoints,
            'dealer_cards' => $dealerCards,
            'dealer_points' => $dealerPoints,
        ]);
    }
    #[Route("/card21/reset", name: "game21_reset")]
    public function resetGame(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute('game21_start');
    }

}
