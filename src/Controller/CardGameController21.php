<?php

namespace App\Controller;

use App\Card\Deck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController21 extends AbstractController
{
    // #[Route("/session", name: "session_store")]
    // public function sessionView(SessionInterface $session): Response
    // {
    //     return $this->render('card/session.html.twig', [
    //         'session' => $session->all()
    //     ]);
    // }
    // #[Route("/session/delete", name: "session_delete")]
    // public function sessionDelete(SessionInterface $session): Response
    // {
    //     $session->clear();
    //     $this->addFlash('notice', 'Session hasn been deleted.');

    //     return $this->redirectToRoute('session_store');
    // }

    #[Route("/21game/card", name: "21card_start")]
    public function home(): Response
    {
        return $this->render('card21/home.html.twig');
    }
    

    #[Route("/21card/start", name: "game21_start")]
    public function startGame(SessionInterface $session): Response
    {
        // Initialize deck and hands
        $deck = new Deck();
        $deck->shuffle();
        $session->set('deck21', $deck);

        $playerCards = $deck->draw(2);
        $dealerCards = $deck->draw(2);

        // Store the player and dealer hands in session
        $session->set('player_cards', $playerCards);
        $session->set('dealer_cards', $dealerCards);

        return $this->render('card21/start.html.twig', [
            'player_cards' => $playerCards,
            'dealer_cards' => $dealerCards,
            'player_points' => $this->calculatePoints($playerCards),
            'dealer_points' => $this->calculatePoints($dealerCards),
        ]);
    }

}
