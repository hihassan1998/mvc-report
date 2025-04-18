<?php


namespace App\Controller;

use App\Card\Deck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/session", name: "session_store")]
    public function sessionView(SessionInterface $session): Response
    {
        return $this->render('card/session.html.twig', [
            'session' => $session->all()
        ]);
    }
    #[Route("/session/delete", name: "session_delete")]
    public function sessionDelete(SessionInterface $session): Response
    {
        $session->clear();
        $this->addFlash('notice', 'Session hasn been deleted.');

        return $this->redirectToRoute('session_store');
    }

    #[Route("/game/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function showDeck(SessionInterface $session): Response
    {
        $deck = new Deck();
        $session->set("deck", $deck);

        return $this->render('card/deck.html.twig', [
            'cards' => $deck->getCards()
        ]);
    }
    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffleDeck(SessionInterface $session): Response
    {
        $deck = new Deck();
        $deck->shuffle();
        $session->set("deck", $deck);

        return $this->render('card/deck.html.twig', [
            'cards' => $deck->getCards()
        ]);
    }
    #[Route("/card/deck/draw", name: "card_draw")]
    public function drawOne(SessionInterface $session): Response
    {
        $deck = $session->get("deck", new Deck());

        $deck->shuffle();

        $card = $deck->draw(1);
        $session->set("deck", $deck);

        return $this->render('card/draw.html.twig', [
            'drawn' => $card,
            'remaining' => $deck->count()
        ]);
    }
    #[Route("/card/deck/draw/{num<\d+>}", name: "card_draw_number")]
    public function drawNumber(int $num, SessionInterface $session): Response
    {
        $deck = $session->get('deck', new Deck());
        $cards = $deck->draw($num);
        $session->set('deck', $deck);

        return $this->render('card/draw_number.html.twig', [
            'cards' => $cards,
            'remaining' => count($deck->getCards())
        ]);
    }
}
