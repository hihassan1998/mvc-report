<?php

namespace App\Controller;

use App\Card\Game21Service;
use App\Card\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for the "21" card game.
 */
class CardGameController21 extends AbstractController
{
    private Game21Service $gameService;

    /**
     * Constructor to inject the Game21Service.
     *
     * @param Game21Service $gameService The game logic service for 21.
     */
    public function __construct(Game21Service $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * Landing page for the 21 card game.
     *
     * @return Response Rendered homepage.
     */
    #[Route("/21game/card", name: "21card_start")]
    public function home(): Response
    {
        return $this->render('card21/home.html.twig');
    }

    /**
     * Displays documentation for the 21 card game.
     *
     * @return Response Rendered documentation page.
     */
    #[Route("/game/doc", name: "21card_docs")]
    public function docs(): Response
    {
        return $this->render('card21/docs.html.twig');
    }

    /**
     * Starts the 21 card game and initializes the session state.
     *
     * @param SessionInterface $session The session interface.
     * @return Response Rendered game start page.
     */
    #[Route("/21card/start", name: "game21_start")]
    public function startGame(SessionInterface $session): Response
    {
        $showDealer = (bool) $session->get('show_dealer', false);
        if (!$showDealer) {
            $this->gameService->initializeGame($session);
        }

        /** @var Card[] $playerCards */
        $playerCards = (array) $session->get('player_cards');
        /** @var Card[] $dealerCards */
        $dealerCards = (array) $session->get('dealer_cards');

        return $this->render('card21/start.html.twig', [
            'player_cards' => $playerCards,
            'dealer_cards' => $dealerCards,
            'player_points' => $this->gameService->getPoints($playerCards),
            'dealer_points' => $this->gameService->getPoints($dealerCards),
            'show_dealer' => $showDealer,
        ]);
    }

    /**
     * Handles the player's "hit" action (drawing another card).
     *
     * @param SessionInterface $session The session interface.
     * @return Response Rendered page showing updated state or end game.
     */
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

    /**
     * Handles the player's "stand" action (end turn and let dealer play).
     *
     * @param SessionInterface $session The session interface.
     * @return Response Redirect to game start page.
     */
    #[Route("/card21/stand", name: "game21_stand")]
    public function stand(SessionInterface $session): Response
    {
        $this->gameService->dealerPlays($session);
        return $this->redirectToRoute('game21_start');
    }

    /**
     * Ends the game and displays the result.
     *
     * @param SessionInterface $session The session interface.
     * @return Response Rendered end game page with results.
     */
    #[Route("/card21/end_game", name: "game21_end_game")]
    public function endGame(SessionInterface $session): Response
    {
        $result = $this->gameService->determineResult($session);
        /** @var Card[] $playerCards */
        $playerCards = (array) $session->get('player_cards');
        /** @var Card[] $dealerCards */
        $dealerCards = (array) $session->get('dealer_cards');

        return $this->render('card21/end_game.html.twig', [
            'result' => $result,
            'player_cards' => $playerCards,
            'dealer_cards' => $dealerCards,
            'player_points' => $this->gameService->getPoints($playerCards),
            'dealer_points' => $this->gameService->getPoints($dealerCards),
        ]);
    }
    /**
     * Resets the game session and redirects to the start page.
     *
     * @param SessionInterface $session The session interface.
     * @return Response Redirect response.
     */
    #[Route("/card21/reset", name: "game21_reset")]
    public function resetGame(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute('game21_start');
    }
}
