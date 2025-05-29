<?php

namespace App\Controller;

use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API controller that returns random numbers and quotes in JSON format.
 */
class LuckyControllerJson
{
    /**
     * Returns a JSON response with a random lucky number and a message.
     *
     * @return Response JSON-formatted response with a lucky number.
     */
    #[Route("/api/lucky/number", "api_lucky_number")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Hi there!',
        ];

        // return new JsonResponse($data);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    /**
     * Returns a JSON response with a random inspirational quote and timestamp.
     *
     * @return Response JSON-formatted response with a quote, date, and timestamp.
     */
    #[Route("/api/quote", name: "api_quote")]
    public function quote(): Response
    {
        $quotes = [
            "Today is your lucky day!",
            "Greate friends are hard to find",
            "The fortune cookie never lies!",
            "A surprise is waiting for you soon.",
            "Being stress-free is a construct of mind",
        ];

        $randomQuote = $quotes[array_rand($quotes)];

        $date = new DateTime();

        $data = [
            'quote' => $randomQuote,
            'date' => $date->format('Y-m-d'),
            'timestamp' => $date->getTimestamp(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
