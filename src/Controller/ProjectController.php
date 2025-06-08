<?php

namespace App\Controller;

use App\Repository\EmissionsDataRepository;
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
     * @param GoalArticleRepository $goalArticleRepository The repository for goal articles.
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

    /**
     * Search for goals by name, definition, article content, or goal number.
     * Returns JSON for AJAX/JSON requests, otherwise renders an HTML view.
     *
     * @param Request $request The HTTP request object.
     * @param GoalArticleRepository $goalArticleRepository Repository to search goal data.
     * @return Response JSON response or rendered HTML template with search results.
     */
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
                ->setParameter('query', '%' . strtolower((string) $query) . '%')
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

    /**
     * Displays a simple goal 12 page for the goal 12 tables display route.
     *
     * @return Response
     */
    #[Route('/proj/goals/view12', name: 'app_proj_goal_12')]
    public function viewGoal12(
        GoalArticleRepository $goalArticleRepository,
        EmissionsDataRepository $emissionsDataRepository
    ): Response {
        $goal = $goalArticleRepository->findOneBy(['number' => 12]);
        if (!$goal) {
            throw $this->createNotFoundException('Goal not found');
        }
        $emissiondata = $emissionsDataRepository->findAll();
        // Sum totals
        $sumSweden = 0;
        $sumAbroad = 0;
        $sumTotal = 0;

        foreach ($emissiondata as $data) {
            $sumSweden += $data->getEmissionsSweden();
            $sumAbroad += $data->getEmissionsAbroad();
            $sumTotal += $data->getTotal();
        }
        return $this->render('proj/goal12.html.twig', [
            'goal' => $goal,
            'emissiondata' => $emissiondata,
            'sumSweden' => $sumSweden,
            'sumAbroad' => $sumAbroad,
            'sumTotal' => $sumTotal,
        ]);
    }

}
