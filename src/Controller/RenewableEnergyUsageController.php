<?php

namespace App\Controller;

use App\Entity\RenewableEnergyUsage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for seeding RenewableEnergyUsage data.
 */
class RenewableEnergyUsageController extends AbstractController
{
    #[Route('/proj/goal/7/init-usage-data', name: 'proj_goal7_init_usage_data')]
    public function initUsageData(EntityManagerInterface $entityManager): Response
    {
        $years = [
            2005,
            2006,
            2007,
            2008,
            2009,
            2010,
            2011,
            2012,
            2013,
            2014,
            2015,
            2016,
            2017
        ];

        $goals = [168, 174, 182, 182, 188, 199, 197, 208, 206, 204, 210, 217, 223];
        $totals = [414, 409, 411, 402, 391, 422, 405, 406, 397, 389, 394, 409, 410];

        $existing = $entityManager->getRepository(RenewableEnergyUsage::class)->count([]);
        if ($existing > 0) {
            $response = $this->json(['message' => 'Data finns redan i databasen.']);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        foreach ($years as $i => $year) {
            $usage = new RenewableEnergyUsage();
            $usage->setYear($year)
                ->setRenewableEnergyGoal($goals[$i])
                ->setTotalRenewableEnergy($totals[$i]);

            $entityManager->persist($usage);
        }

        $entityManager->flush();
        $response = $this->json(['message' => 'Mål 7 tabel 1 data har laddats in i databasen.']);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
