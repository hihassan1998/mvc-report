<?php

namespace App\Controller;

use App\Repository\GoalArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;


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
     * @param int $number
     * @return Response
     */
    #[Route('proj/goals/view/{number}', name: 'app_proj_goal_by_id')]
    public function viewGoalById(
        GoalArticleRepository $goalArticleRepository,
        int $number
    ): Response {
        $goal = $goalArticleRepository->findOneBy(['number' => $number]);
        if (!$goal) {
            throw $this->createNotFoundException('Goal not found');
        }

        return $this->render('proj/goal.html.twig', [
            'goal' => $goal,
        ]);
    }

    /**
     * Displays a simple Json api listings page for the /proj/api route.
     *
     * @return Response
     */
    #[Route('/proj/api', name: 'app_proj_api')]
    public function projApi(): Response
    {
        return $this->render('proj/proj_api.html.twig');
    }

    #[Route('/proj/goals/search', name: 'proj_goal_search', methods: ['POST', 'GET'])]
    public function searchGoals(
        Request $request,
        GoalArticleRepository $goalArticleRepository
    ): Response {
        $query = $request->request->get('query', '');

        $goals = [];
        if ($query) {
            $qb = $goalArticleRepository->createQueryBuilder('g')
                ->where('LOWER(g.name) LIKE :query')
                ->orWhere('LOWER(g.defination) LIKE :query')
                ->orWhere('LOWER(g.article) LIKE :query');

            if (is_numeric($query)) {
                $qb->orWhere('g.number = :number')
                    ->setParameter('number', (int) $query);
            }

            $goals = $qb
                ->setParameter('query', '%' . strtolower($query) . '%')
                ->getQuery()
                ->getResult();
        }

        if ($request->isXmlHttpRequest() || $request->getRequestFormat() === 'json' || $request->query->get('format') === 'json') {
            return $this->json($goals, 200, [], ['json_encode_options' => JSON_PRETTY_PRINT]);
        }

        return $this->render('proj/goals_search_results.html.twig', [
            'goals' => $goals,
            'query' => $query,
        ]);
    }

}
