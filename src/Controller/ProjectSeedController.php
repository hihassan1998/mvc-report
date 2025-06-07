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

        $goalsData = [
            [
                'number' => 1,
                'name' => 'Ingen fattigdom',
                'description' => 'Fattigdom omfattar fler dimensioner än den ekonomiska. Fattigdom innebär bl.a. även brist på frihet, makt, inflytande, hälsa, utbildning och fysisk säkerhet.',
                'definition' => 'End poverty in all its forms everywhere.',
                'articleTitle' => 'About No Poverty',
                'article' => 'This goal aims to eradicate poverty globally by 2030.'
            ],
            [
                'number' => 2,
                'name' => 'Ingen hunger',
                'description' => 'Avskaffa hunger, uppnå tryggad livsmedelsförsörjning och förbättrad nutrition samt främja ett hållbart jordbruk.',

                'definition' => 'End hunger, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Zero Hunger',
                'article' => 'Focuses on sustainable food production systems and resilient agricultural practices.'
            ],
            [
                'number' => 3,
                'name' => 'God hälsa och välbefinnande',
                'description' => 'Säkerställa hälsosamma liv och främja välbefinnande för alla i alla åldrar.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 4,
                'name' => 'God utbildning för alla',
                'description' => 'Säkerställa en inkluderande och likvärdig utbildning av god kvalitet och främja livslångt lärande för alla.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 5,
                'name' => 'Jämställdhet',
                'description' => 'Uppnå jämställdhet och alla kvinnors och flickors egenmakt.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 6,
                'name' => 'Rent vatten och sanitet för alla',
                'description' => 'Säkerställa tillgången till och en hållbar förvaltning av vatten och sanitet för alla.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 7,
                'name' => 'Hållbar energi för alla',
                'description' => 'Säkerställa tillgång till ekonomiskt överkomlig, tillförlitlig, hållbar och modern energi för alla.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 8,
                'name' => 'Anständiga arbetsvillkor och ekonomisk tillväxt',
                'description' => 'Verka för varaktig, inkluderande och hållbar ekonomisk tillväxt, full och produktiv sysselsättning med anständiga arbetsvillkor för alla.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 9,
                'name' => 'Hållbar industri, innovationer och infrastruktur',
                'description' => 'Bygga motståndskraftig infrastruktur, verka för en inkluderande och hållbar industrialisering samt främja innovation.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 10,
                'name' => 'Minskad ojämlikhet',
                'description' => 'Minska ojämlikheten inom och mellan länder',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 11,
                'name' => 'Hållbara städer och samhällen',
                'description' => 'Göra städer och bosättningar inkluderande, säkra, motståndskraftiga och hållbara.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 12,
                'name' => 'Hållbar konsumtion och produktion',
                'description' => 'Säkerställa hållbara konsumtions- och produktionsmönster.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 13,
                'name' => 'Bekämpa klimatförändringarna',
                'description' => 'Vidta omedelbara åtgärder för att bekämpa klimatförändringarna och dess konsekvenser.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 14,
                'name' => 'Hav och marina resurser',
                'description' => 'Bevara och nyttja haven och de marina resurserna på ett hållbart sätt för en hållbar utveckling.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 15,
                'name' => 'Ekosystem och biologisk mångfald',
                'description' => 'Skydda, återställa och främja ett hållbart nyttjande av landbaserade ekosystem, hållbart bruka skogar, bekämpa ökenspridning, hejda och vrida tillbaka markförstöringen samt hejda förlusten av biologisk mångfald.',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 16,
                'name' => 'Fredliga och inkluderande samhällen',
                'description' => 'Främja fredliga och inkluderande samhällen för hållbar utveckling, tillhandahålla tillgång till rättvisa för alla samt bygga upp effektiva, och inkluderande institutioner med ansvarsutkrävande på alla nivåer',

                'definition' => 'End project, achieve food security and improved nutrition and promote sustainable agriculture.',
                'articleTitle' => 'About Project',
                'article' => 'Focuses on sustainable project delivery, production systems and resilient coding practices.'
            ],
            [
                'number' => 17,
                'name' => 'Genomförande och globalt partnerskap',
                'description' => 'Stärka genomförandemedlen och återvitalisera det globala partnerskapet för hållbar utveckling.',

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
