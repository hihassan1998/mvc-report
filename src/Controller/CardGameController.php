<?php

namespace App\Controller;

use App\Card\Deck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for handling card game interactions including session storage,
 * deck creation, shuffling, and card drawing.
 */
class CardGameController extends AbstractController
{
    /**
     * Display the current session data.
     *
     * @param SessionInterface $session The current session.
     * @return Response Rendered session view.
     */
    #[Route("/session", name: "session_store")]
    public function sessionView(SessionInterface $session): Response
    {
        return $this->render('card/session.html.twig', [
            'session' => $session->all()
        ]);
    }

    /**
     * Clear all session data.
     *
     * @param SessionInterface $session The current session.
     * @return Response Redirect to session view after deletion.
     */
    #[Route("/session/delete", name: "session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {
        $session->clear();
        $this->addFlash('notice', 'Session hasn been deleted.');

        return $this->redirectToRoute('session_store');
    }

    /**
     * Display the start page for the card game.
     *
     * @return Response Rendered home view.
     */
    #[Route("/game/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    /**
     * Show a new deck of cards and store it in the session.
     *
     * @param SessionInterface $session The current session.
     * @return Response Rendered view of the new deck.
     */
    #[Route("/card/deck", name: "card_deck")]
    public function showDeck(SessionInterface $session): Response
    {
        $deck = new Deck();
        $session->set("deck", $deck);

        $this->addFlash('notice', 'A new deck has been created.');

        return $this->render('card/deck.html.twig', [
            'cards' => $deck->getCards()
        ]);
    }

    /**
     * Shuffle a new deck and store it in the session.
     *
     * @param SessionInterface $session The current session.
     * @return Response Rendered view of the shuffled deck.
     */
    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffleDeck(SessionInterface $session): Response
    {
        /** @var Deck $deck */
        $deck = new Deck();
        $deck->shuffle();
        $session->set("deck", $deck);

        $this->addFlash('notice', 'Deck has been shuffled.');

        return $this->render('card/deck.html.twig', [
            'cards' => $deck->getCards()
        ]);
    }

    /**
     * Draw one card from the deck.
     *
     * @param SessionInterface $session The current session.
     * @return Response Rendered view showing the drawn card and remaining count.
     */
    #[Route("/card/deck/draw", name: "card_draw")]
    public function drawOne(SessionInterface $session): Response
    {
        /** @var Deck $deck */
        $deck = $session->get("deck", new Deck());

        $deck->shuffle();

        $card = $deck->draw(1);
        $session->set("deck", $deck);

        return $this->render('card/draw.html.twig', [
            'drawn' => $card,
            'remaining' => $deck->count()
        ]);
    }

    /**
     * Draw a specified number of cards from the deck.
     *
     * @param int $num Number of cards to draw.
     * @param SessionInterface $session The current session.
     * @return Response Rendered view showing drawn cards and remaining count.
     */
    #[Route("/card/deck/draw/{num<\d+>}", name: "card_draw_number")]
    public function drawNumber(int $num, SessionInterface $session): Response
    {
        /** @var Deck $deck */
        $deck = $session->get('deck', new Deck());
        if ($num > $deck->count()) {
            $this->addFlash(
                'warning',
                "Cannot draw more cards than are available in the deck. Only {$deck->count()} cards left."
            );
        }
        $cards = $deck->draw($num);
        $session->set('deck', $deck);

        return $this->render('card/draw_number.html.twig', [
            'cards' => $cards,
            'remaining' => count($deck->getCards())
        ]);
    }
}
