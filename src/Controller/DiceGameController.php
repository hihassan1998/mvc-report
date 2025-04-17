<?php


namespace App\Controller;

use App\Dice\Dice;
use App\Dice\DiceGraphic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiceGameController extends AbstractController
{

    #[Route("/game/pig", name: "pig_start")]
    public function home(): Response
    {
        return $this->render('pig/home.html.twig');
    }
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
            throw new \Exception("Can not roll more than 99 dices!");
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
}
