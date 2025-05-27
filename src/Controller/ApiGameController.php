<?php

namespace App\Controller;

use App\Card\GameHelper;
use App\Card\Card;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for handling game state retrieval in JSON format from the 21-game API.
 */
class ApiGameController extends AbstractController
{
    private GameHelper $gameHelper;
    /**
     * Constructor to inject the game helper service.
     *
     * @param GameHelper $gameHelper
     */
    public function __construct(GameHelper $gameHelper)
    {
        $this->gameHelper = $gameHelper;
    }

    /**
     * API endpoint to get the current game state for player and dealer.
     *
     * @param SessionInterface $session
     * @return JsonResponse JSON with player/dealer cards, points, and game status
     */
    #[Route('/api/game', name: 'api_game', methods: ['GET'])]
    public function apiGame(SessionInterface $session): JsonResponse
    {

        /** @var Card[] $playerCards */
        $playerCards = $session->get('player_cards', []);

        /** @var Card[] $dealerCards */
        $dealerCards = $session->get('dealer_cards', []);

        $showDealer = $session->get('show_dealer', false);

        $playerPoints = $this->gameHelper->calculatePoints($playerCards);
        $dealerPoints = $this->gameHelper->calculatePoints($dealerCards);

        $data = [
            'player' => [
                'cards' => array_map(fn ($card) => (string) $card, $playerCards),
                'points' => $playerPoints
            ],
            'dealer' => [
                'cards' => $showDealer ? array_map(fn ($card) => (string) $card, $dealerCards) : ['Hidden'],
                'points' => $showDealer ? $dealerPoints : 'Hidden'
            ],
            'game_over' => $playerPoints > 21 || $dealerPoints > 21 || $showDealer
        ];
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
