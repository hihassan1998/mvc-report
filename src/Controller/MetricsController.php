<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Controller for PHP Metrics Report.
 *
 * Handles route for viewing or analyzing Php metrics report.
 */
class MetricsController extends AbstractController
{
    /**
     * Displays a simple page for the /book route.
     *
     * @return Response
     */
    #[Route('/metrics', name: 'app_metrics')]
    public function metrics(): Response
    {
        return $this->render('metrics.html.twig');
    }
}
