<?php

namespace App\Controller;

use App\Entity\RenewableEnergyShare;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for seeding renewable energy share data.
 */
class RenewableEnergyShareController extends AbstractController
{
    #[Route('/proj/goal/7/init-data', name: 'proj_goal7_init_data')]
    public function initRenewableData(EntityManagerInterface $entityManager): Response
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

        $totals = [41, 43, 44, 45, 48, 47, 49, 51, 52, 52, 54, 54, 54];
        $heat = [52, 56, 59, 61, 64, 61, 62, 66, 67, 68, 69, 69, 69];
        $electricity = [51, 52, 53, 54, 58, 56, 60, 60, 62, 63, 66, 65, 66];
        $transport = [6, 7, 8, 8, 9, 9, 12, 15, 18, 20, 23, 29, 27];

        // Check if data already exists
        $existing = $entityManager->getRepository(RenewableEnergyShare::class)->count([]);
        if ($existing > 0) {
            $response = $this->json(['message' => 'Data finns redan i databasen.']);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        foreach ($years as $i => $year) {
            $entry = new RenewableEnergyShare();
            $entry->setYear($year)
                ->setTotal($totals[$i])
                ->setHeatIndustry($heat[$i])
                ->setElectricity($electricity[$i])
                ->setTransport($transport[$i]);

            $entityManager->persist($entry);
        }

        $entityManager->flush();

        $response = $this->json(['message' =>  'Mål 7 tabel 1 data har laddats in i databasen.']);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
