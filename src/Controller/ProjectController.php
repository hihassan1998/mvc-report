<?php

namespace App\Controller;

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
}
