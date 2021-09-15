<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Project;
use App\Form\MessageType;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function contactUs(Request $request, MessageType $messageType): Response
    {
        $em = $this->getDoctrine()->getManager();

        $messageObject = new Message();

        $form = $this->createForm(MessageType::class, $messageObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message = $form->getData();
            var_dump($message);
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('contactUs');
        }


        return $this->render('user/contactUs.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView()
        ]);
    }
}
