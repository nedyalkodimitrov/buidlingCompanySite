<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

      /**
     * @Route("/projects", name="projects")
     */
    public function projects(ProjectRepository $project): Response
    {
        $projects = $project->findAll();

        

        return $this->render('user/projects/projects.html.twig', [
            'controller_name' => 'UserController',
            'projects' => $projects,
        ]);
    }

      /**
     * @Route("/contactUs", name="contactUs")
     */
    public function contactUs(): Response
    {
        

        return $this->render('user/contactUs.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
