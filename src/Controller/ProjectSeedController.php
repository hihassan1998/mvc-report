<?php

// src/Controller/ProjectSeedController.php

namespace App\Controller;

use App\Entity\GoalArticle;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectSeedController extends AbstractController
{
    #[Route('/proj/goals/seed', name: 'proj_goals_seed')]
    public function seedGoals(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $goalsData =  $goalsData = require __DIR__ . '/../../config/goals_data.php';
        $existing = $entityManager->getRepository(GoalArticle::class)->count([]);
        if ($existing > 0) {
            $response = $this->json(['message' => 'Data finns redan i databasen.']);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        foreach ($goalsData as $data) {
            $goal = new GoalArticle();
            $goal->setNumber($data['number']);
            $goal->setName($data['name']);
            $goal->setDescription($data['description']);
            $goal->setDefination($data['definition']);
            $goal->setArticleTitle($data['articleTitle']);
            $goal->setArticle($data['article']);

            $entityManager->persist($goal);
        }

        $entityManager->flush();
        $response = $this->json(['message' => count($goalsData) . ' goals seeded successfully.']);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
