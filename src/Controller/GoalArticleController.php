<?php

// src/Controller/GoalArticleController.php

namespace App\Controller;

use App\Entity\GoalArticle;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoalArticleController extends AbstractController
{
    #[Route('/proj/goals/seed', name: 'proj_goals_seed')]
    public function seedGoals(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $goalsData = [
            [
                'number' => 1,
                'name' => 'No Poverty',
                'description' => 'End poverty in all its forms everywhere.',
                'definition' => 'End poverty in all its forms everywhere.',
                'articleTitle' => 'About No Poverty',
                'article' => 'This goal aims to eradicate poverty globally by 2030.'
            ],
            [
                'number' => 2,
                'name' => 'Zero Hunger',
                'description' => 'End poverty in all its forms everywhere.',

                'definition' => 'End hunger, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Zero Hunger',
                'article' => 'Focuses on sustainable food production systems and resilient agricultural practices.'
            ],
            [
                'number' => 3,
                'name' => 'Hassan Success',
                'description' => 'End poverty in all its forms everywhere.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
        ];

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

        return new Response(count($goalsData) . ' goals seeded successfully.');
    }
}
