<?php

namespace App\Controller;

use App\Card\Deck;
use App\Card\GameHelper;
use App\Card\Card;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private GameHelper $gameHelper;

    public function __construct(GameHelper $gameHelper)
    {
        $this->gameHelper = $gameHelper;
    }

    #[Route("/api", name: "api")]
    public function api(): Response
    {
        $routes = [
            'api_lucky_number' => 'Route: /api/lucky/number Få json-data för Lucky number',
            'api_quote' => 'Route: /api/quote Få json-data för dagens offert, datum, tidsstämpel',
        ];

        return $this->render('api.html.twig', [
            'routes' => $routes
        ]);
    }
    #[Route('/api/deck', name: 'api_deck', methods: ['GET'])]
    public function apiDeck(): JsonResponse
    {
        $deck = new Deck();

        $response = new JsonResponse(['deck' => $deck->getGroupedBySuit()]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
    #[Route('/api/deck/shuffle', name: 'api_deck_shuffle', methods: ["GET", 'POST'])]
    public function shuffle(SessionInterface $session): JsonResponse
    {
        $deck = new Deck();
        $deck->shuffle();

        $session->set('deck', $deck);

        $response = new JsonResponse(['deck' => $deck->getGroupedBySuit()]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
    #[Route("/api/deck/draw", name: "draw_card", methods: ["GET", 'POST'])]
    public function drawCard(SessionInterface $session): JsonResponse
    {

        /** @var Deck $deck */
        $deck = $session->get("deck", new Deck());

        $deck->shuffle();

        $card = $deck->draw(1);
        $session->set("deck", $deck);

        $response = new JsonResponse([
            'drawn_cards' => $card,
            'remaining_cards' => $deck->count()
        ]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route("/api/deck/draw/{num<\d+>}", name: "draw_multiple_cards", methods: ["GET", "POST"])]
    public function drawNumber(int $num, SessionInterface $session): JsonResponse
    {
        /** @var Deck $deck */
        $deck = $session->get('deck', new Deck());
        if ($num > $deck->count()) {
            return new JsonResponse("Desired number of drawn cards is greater than available cards in deck", 400);
        }
        $cards = $deck->draw($num);
        $session->set('deck', $deck);

        $response = new JsonResponse([
            'drawn_cards' => $cards,
            'remaining_cards' => $deck->count()
        ]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route('/api/game', name: 'api_game', methods: ['GET'])]
    public function apiGame(SessionInterface $session): JsonResponse
    {
        // $playerCards = (array)  $session->get('player_cards', []);
        // $dealerCards = (array)  $session->get('dealer_cards', []);
        // $playerCards = $session->get('player_cards', []);
        // if (!is_array($playerCards)) {
        //     $playerCards = [];
        // }

        // $dealerCards = $session->get('dealer_cards', []);
        // if (!is_array($dealerCards)) {
        //     $dealerCards = [];
        // }
        /** @var Card[] $playerCards */
        $playerCards = $session->get('player_cards', []);
        // if (!is_array($playerCards)) {
        //     $playerCards = [];
        // }

        /** @var Card[] $dealerCards */
        $dealerCards = $session->get('dealer_cards', []);
        // if (!is_array($dealerCards)) {
        //     $dealerCards = [];
        // }

        $showDealer = $session->get('show_dealer', false);

        $playerPoints = $this->gameHelper->calculatePoints($playerCards);
        $dealerPoints = $this->gameHelper->calculatePoints($dealerCards);
        // $playerPoints = $this->gameHelper->calculatePoints(is_array($playerCards) ? $playerCards : []);
        // $dealerPoints = $this->gameHelper->calculatePoints(is_array($dealerCards) ? $dealerCards : []);

        $data = [
            'player' => [
                'cards' => array_map(fn ($card) => (string) $card, $playerCards),
                // 'cards' =>  is_array($playerCards) ? array_map(fn ($card) => (string) $card, $playerCards) : [],
                // 'cards' => array_map(
                //     fn($card) => is_object($card) && method_exists($card, '__toString') ? (string) $card : 'Invalid Card',
                //     $playerCards
                // ),

                'points' => $playerPoints
            ],
            'dealer' => [
                'cards' => $showDealer ? array_map(fn ($card) => (string) $card, $dealerCards) : ['Hidden'],
                // 'cards' => is_array($dealerCards) ? array_map(fn ($card) => (string) $card, $dealerCards) : ['Hidden'],
                // 'cards' => $showDealer
                //     ? array_map(
                //         fn($card) => is_object($card) && method_exists($card, '__toString') ? (string) $card : 'Invalid Card',
                //         $dealerCards
                //     )
                //     : ['Hidden'],

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
