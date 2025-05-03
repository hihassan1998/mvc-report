<?php

namespace App\Controller;

use App\Card\Game21Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController21 extends AbstractController
{
    private Game21Service $gameService;

    public function __construct(Game21Service $gameService)
    {
        $this->gameService = $gameService;
    }

    #[Route("/21game/card", name: "21card_start")]
    public function home(): Response
    {
        return $this->render('card21/home.html.twig');
    }

    #[Route("/21card/start", name: "game21_start")]
    public function startGame(SessionInterface $session): Response
    {
        $showDealer = (bool) $session->get('show_dealer', false);
        if (!$showDealer) {
            $this->gameService->initializeGame($session);
        }

        $playerCards = $session->get('player_cards');
        $dealerCards = $session->get('dealer_cards');

        return $this->render('card21/start.html.twig', [
            'player_cards' => $playerCards,
            'dealer_cards' => $dealerCards,
            'player_points' => $this->gameService->getPoints($playerCards),
            'dealer_points' => $this->gameService->getPoints($dealerCards),
            'show_dealer' => $showDealer,
        ]);
    }

    #[Route("/game21/hit", name: "game21_hit")]
    public function hit(SessionInterface $session): Response
    {
        $data = $this->gameService->playerHit($session);

        if ($data['player_points'] > 21) {
            return $this->render('card21/end_game.html.twig', [
                'message' => 'You busted!',
                ...$data,
                'show_dealer' => (bool) $session->get('show_dealer', false),
            ]);
        }

        return $this->render('card21/start.html.twig', [
            ...$data,
            'show_dealer' => (bool) $session->get('show_dealer', false),
        ]);
    }

    #[Route("/card21/stand", name: "game21_stand")]
    public function stand(SessionInterface $session): Response
    {
        $this->gameService->dealerPlays($session);
        return $this->redirectToRoute('game21_start');
    }

    #[Route("/card21/end_game", name: "game21_end_game")]
    public function endGame(SessionInterface $session): Response
    {
        $result = $this->gameService->determineResult($session);
        $playerCards = $session->get('player_cards');
        $dealerCards = $session->get('dealer_cards');

        return $this->render('card21/end_game.html.twig', [
            'result' => $result,
            'player_cards' => $playerCards,
            'dealer_cards' => $dealerCards,
            'player_points' => $this->gameService->getPoints($playerCards),
            'dealer_points' => $this->gameService->getPoints($dealerCards),
        ]);
    }

    #[Route("/card21/reset", name: "game21_reset")]
    public function resetGame(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute('game21_start');
    }
}
