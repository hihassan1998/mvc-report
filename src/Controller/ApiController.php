<?php

namespace App\Controller;

use App\Card\Deck;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 *
 * Provides various API endpoints of a deck of cards as JSON data responses.
 */
class ApiController extends AbstractController
{
    /**
     * Render a list of available API routes.
     *
     * @return Response HTML page listing available API endpoints.
     */
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
    /**
     * Return a full, grouped deck of cards as JSON.
     *
     * @return JsonResponse JSON representation of the full deck grouped by suit.
     */
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
    /**
     * Shuffle the deck and store it in the session.
     *
     * @param SessionInterface $session The current session instance.
     *
     * @return JsonResponse JSON representation of the shuffled deck grouped by suit.
     */
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
    /**
     * Draw a single card from the session's deck and return it.
     *
     * @param SessionInterface $session The current session instance.
     *
     * @return JsonResponse JSON with the drawn card and remaining count.
     */
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
    /**
     * Draw a specific number of cards from the deck and return them.
     *
     * @param int $num The number of cards to draw.
     * @param SessionInterface $session The current session instance.
     *
     * @return JsonResponse JSON with drawn cards and remaining count, or error if too many requested.
     */
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
}
