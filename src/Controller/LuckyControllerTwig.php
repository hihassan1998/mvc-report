<?php

namespace App\Controller;

// use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky/number/twig", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky_number.html.twig', $data);
    }

    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/lucky", name: "lucky")]
    public function luckyHome(): Response
    {
        $images = [
            "background.jpg",
            "banner.jpg",
            "mvc.png",
            "hassanicon.png",
            "glider.svg",
        ];
        $number = random_int(0, 100);
        $randomImage = $images[array_rand($images)];

        $data = [
            'lucky-number' => $number,
            'lucky-image' => $randomImage,
        ];

        return $this->render('lucky.html.twig', [
            'number' => $data['lucky-number'],
            'image' => $data['lucky-image'],
        ]);
    }
}
