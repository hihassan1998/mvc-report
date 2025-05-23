<?php

namespace App\Controller;

use App\Dice\Dice;
use App\Dice\DiceGraphic;
use App\Dice\DiceHand;
use Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiceGameController extends AbstractController
{
    #[Route("/game/pig", name: "pig_start")]
    public function home(): Response
    {
        return $this->render('pig/home.html.twig');
    }
    // route for game start form
    #[Route("/game/pig/init", name: "pig_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('pig/init.html.twig');
    }
    #[Route("/game/pig/init", name: "pig_init_post", methods: ['POST'])]
    public function initCallback(Request $request, SessionInterface $session): Response
    {
        $numDice = $request->request->get('num_dices');

        $hand = new DiceHand();
        for ($i = 1; $i <= $numDice; $i++) {
            $hand->add(new DiceGraphic());
        }
        $hand->roll();

        $session->set("pig_dicehand", $hand);

        $session->set("pig_dices", $numDice);
        $session->set("pig_round", 0);
        $session->set("pig_total", 0);

        return $this->redirectToRoute('pig_play');
    }
    #[Route("/game/pig/play", name: "pig_play", methods: ['GET'])]
    public function play(SessionInterface $session): Response
    {
        $dicehand = $session->get("pig_dicehand");

        if (!$dicehand instanceof DiceHand) {
            throw new RuntimeException("DiceHand not found in session.");
        }

        $data = [
            "pigDices" => $session->get("pig_dices"),
            "pigRound" => $session->get("pig_round"),
            "pigTotal" => $session->get("pig_total"),
            "diceValues" => $dicehand->getString()
        ];

        return $this->render('pig/play.html.twig', $data);
    }
    #[Route("/game/pig/roll", name: "pig_roll", methods: ['POST'])]
    public function roll(
        SessionInterface $session
    ): Response {
        $hand = $session->get("pig_dicehand");

        if (!$hand instanceof DiceHand) {
            throw new RuntimeException("DiceHand not found in session.");
        }
        $hand->roll();

        $roundTotal = $session->get("pig_round", 0);

        if (!is_numeric($roundTotal)) {
            $roundTotal = 0;
        }
        $round = 0;
        $values = $hand->getValues();
        foreach ($values as $value) {
            if ($value === 1) {
                $round = 0;
                $roundTotal = 0;
                $this->addFlash(
                    'warning',
                    'You got a 1 and you lost the round points!'
                );
                break;
            }
            $round += $value;
        }

        $session->set("pig_round", (int) $roundTotal + (int) $round);

        return $this->redirectToRoute('pig_play');
    }
    #[Route("/game/pig/save", name: "pig_save", methods: ['POST'])]
    public function save(SessionInterface $session): Response
    {
        $roundTotal = $session->get("pig_round");
        $gameTotal = $session->get("pig_total");

        if (!is_int($roundTotal) || !is_int($gameTotal)) {
            throw new RuntimeException("Invalid score values in session.");
        }

        $session->set("pig_round", 0);
        $session->set("pig_total", $roundTotal + $gameTotal);

        $this->addFlash(
            'notice',
            'Your round was saved to the total!'
        );

        return $this->redirectToRoute('pig_play');
    }

    // test routes
    #[Route("/game/pig/test/roll", name: "test_roll_dice")]
    public function testRollDice(): Response
    {
        $die = new Dice();

        $data = [
            "dice" => $die->roll(),
            "diceString" => $die->getAsString(),
        ];

        return $this->render('pig/test/roll.html.twig', $data);
    }
    #[Route("/game/pig/test/roll/{num<\d+>}", name: "test_roll_num_dices")]
    public function testRollDices(int $num): Response
    {
        // Check and limit numder of rolls
        if ($num > 99) {
            throw new Exception("Can not roll more than 99 dices!");
        }
        // Run the loop $num of times
        // die = object of Dice class and call its methods
        $diceRoll = [];
        for ($i = 1; $i <= $num; $i++) {
            // use Base class : Dice
            // $die = new Dice();
            // use exteded class of Dice
            $die = new DiceGraphic();
            $die->roll();
            $diceRoll[] = $die->getAsString();
        }
        // Pyhton Syntax:
        // diceRoll = []
        // for i in range(1, num + 1):
        //     die = Dice()
        //     die.roll()
        //     diceRoll.append(die.getAsString())

        // Prepare data to send to template
        $data = [
            "num_dices" => count($diceRoll),
            "diceRoll" => $diceRoll,
        ];
        // return rendered template with data
        return $this->render('pig/test/roll_many.html.twig', $data);
    }
    #[Route("/game/pig/test/dicehand/{num<\d+>}", name: "test_dicehand")]
    public function testDiceHand(int $num): Response
    {
        if ($num > 99) {
            throw new Exception("Can not roll more than 99 dices!");
        }

        $hand = new DiceHand();
        for ($i = 1; $i <= $num; $i++) {
            $hand->add(($i % 2 === 1) ? new DiceGraphic() : new Dice());
        }

        $hand->roll();

        $data = [
            "num_dices" => $hand->getNumberDices(),
            "diceRoll" => $hand->getString(),
        ];

        return $this->render('pig/test/dicehand.html.twig', $data);
    }
}
