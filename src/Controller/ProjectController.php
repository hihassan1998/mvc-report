<?php

namespace App\Controller;

use App\Repository\GoalArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller for the 17 gobal goals project.
 *
 * Handles routes for viewing, creating, editing, and deleting articles.
 */
final class ProjectController extends AbstractController
{
    /**
     * Displays a simple start page for the /proj route.
     *
     * @return Response
     */
    #[Route('/proj', name: 'app_proj')]
    public function index(): Response
    {
        return $this->render('proj/index.html.twig');
    }
    /**
     * Displays a simple about page for the /proj/about route.
     *
     * @return Response
     */
    #[Route('/proj/about', name: 'app_proj_about')]
    public function projAbout(): Response
    {
        return $this->render('proj/about.html.twig');
    }
    /**
     * Displays a simple for gaols page for the /proj/goals route.
     *
     * @return Response
     */
    #[Route('/proj/goals', name: 'app_proj_goals')]
    public function projGoals(GoalArticleRepository $goalArticleRepository): Response
    {
        $goals = $goalArticleRepository->findAll();

        $data = [
            'goals' => $goals
        ];

        return $this->render('proj/goals.html.twig', $data);
    }
    /**
     * Displays a specific book by ID using a Twig template.
     *
     * @param GoalArticleRepository 
     * @param int $id
     * @return Response
     */
    #[Route('proj/goals/view/{id}', name: 'app_proj_goal_by_id')]
    public function viewGoalById(
        GoalArticleRepository $goalArticleRepository,
        int $id
    ): Response {
        $goal = $goalArticleRepository->find($id);

        if (!$goal) {
            throw $this->createNotFoundException('Goal not found');
        }

        return $this->render('proj/goal.html.twig', [
            'goal' => $goal,
        ]);
    }
}
