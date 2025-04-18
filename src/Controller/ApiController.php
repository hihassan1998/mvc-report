<?php

namespace App\Controller;

use App\Card\Deck;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
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
    #[Route('/api/deck/shuffle', name: 'api_deck_shuffle', methods: [ 'POST'])]
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
}
