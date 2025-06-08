<?php

namespace App\Controller;

use App\Repository\EmissionsDataRepository;
use App\Repository\GoalArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * API controller for accessing project data in JSON format.
 *
 */
class ProjectApiController extends AbstractController
{
    /**
     * Get all goals as JSON.
     *
     * @param GoalArticleRepository $goalArticleRepository
     * @return Response JSON response with all goals
     */
    #[Route('proj/api/goals', name: 'proj_show_all')]
    public function showAllGoals(
        GoalArticleRepository $goalArticleRepository
    ): Response {
        $goals = $goalArticleRepository
            ->findAll();

        $response = $this->json($goals);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    /**
     * Get one goal by its number as JSON.
     *
     * @param GoalArticleRepository $goalArticleRepository
     * @param int $number
     * @return Response JSON response with the goal or error if not found
     */
    #[Route('proj/api/goal/{number}', name: 'goal_by_number')]
    public function showGoalByNumber(
        GoalArticleRepository $goalArticleRepository,
        int $number
    ): Response {
        $goal = $goalArticleRepository->findOneBy(['number' => $number]);
        if (!$goal) {
            return $this->json(['error' => 'goal not found'], 404);
        }
        $response = $this->json($goal);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    /**
     * Get all goals as JSON.
     *
     * @param EmissionsDataRepository $emissionsDataRepository
     * @return Response JSON response with all goals
     */
    #[Route('proj/api/emissions', name: 'proj_show_emissions')]
    public function showEmissionsDAta(
        EmissionsDataRepository $emissionsDataRepository
    ): Response {
        $data = $emissionsDataRepository
            ->findAll();

        $response = $this->json($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
