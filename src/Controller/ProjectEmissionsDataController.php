<?php

// src/Controller/EmissionsDataController.php

namespace App\Controller;

use App\Entity\EmissionsData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller för att initiera utsläppsdata för mål 13.
 */
class ProjectEmissionsDataController extends AbstractController
{
    /**
     * Initierar utsläppsdata i databasen om den inte redan finns.
     *
     * @param EntityManagerInterface $entityManager Doctrine entity manager
     * @return Response
     */
    #[Route('/proj/goal/13/init-data', name: 'proj_goal13_init_data')]
    public function initEmissionsData(EntityManagerInterface $entityManager): Response
    {
        $years = [2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016];
        $sweden = [41, 40, 43, 40, 38, 37, 36, 36, 36];
        $abroad = [62, 48, 60, 64, 68, 69, 63, 62, 65];
        $total = [102, 88, 103, 105, 106, 106, 100, 98, 101];

        $existing = $entityManager->getRepository(EmissionsData::class)->count([]);
        if ($existing > 0) {
            $response = $this->json(['message' => 'Data finns redan i databasen.']);
            $response->setEncodingOptions(
                $response->getEncodingOptions() | JSON_PRETTY_PRINT
            );
            return $response;
        }

        foreach ($years as $i => $year) {
            $data = new EmissionsData();
            $data->setYear($year);
            $data->setEmissionsSweden($sweden[$i]);
            $data->setEmissionsAbroad($abroad[$i]);
            $data->setTotal($total[$i]);
            $entityManager->persist($data);
        }

        $entityManager->flush();

        return new Response('Utsläppsdata har laddats in i databasen.');
    }
}
