<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Project;
use App\Form\MessageType;
use App\Form\ProjectType;
use App\Repository\ImageRepository;
use App\Repository\ProjectRepository;
use App\Repository\ProjectsRepository;
use App\Repository\ProjectTypeRepository;
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
    public function projectsView(ProjectRepository $project): Response
    {
        $projects = $project->findAll();

        

        return $this->render('user/projects/allProjects.html.twig', [
            'controller_name' => 'UserController',
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/aboutUs", name="aboutUsView")
     */
    public function aboutUsView(ProjectRepository $project): Response
    {

        return $this->render('user/aboutUs.html.twig', [
            'controller_name' => 'UserController',

        ]);
    }

      /**
     * @Route("/contactUs", name="contactUs")
     */
    public function contactUsView(Request $request, MessageType $messageType): Response
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


    /**
     * @Route("/projects/{type}", name="arrangedProjects")
     */
    public function arrangedProjectsView($type,ProjectRepository $projectRepository, Request $request, MessageType $messageType, ProjectTypeRepository $projectTypeRepository): Response
    {

        $projectType = $projectTypeRepository->findOneBy(["englishName" => $type]);
        $projects = $projectRepository->findBy(["projectType" => $projectType]);

        $readyProjects = [];

        foreach ($projects as $project){
            $projectInfo = [];
            $projectImage = stream_get_contents($project->getProfileImage());
            array_push($projectInfo,$project->getId());
            array_push($projectInfo,$projectImage);
            array_push($projectInfo, $project->getLocation());
            array_push($projectInfo, $project->getProjectType());
            array_push($readyProjects, $projectInfo);

        }


        return $this->render('user/projects/arrangedProjects.html.twig', [
            'controller_name' => 'UserController',
            'projects' => $readyProjects,
            'type' => $projectType->getName()
        ]);


    }



    /**
     * @Route("/project/{id}", name="projectView")
     */
    public function projectView($id,ProjectRepository $projectRepository, ImageRepository $imageRepository): Response
    {
        $project = $projectRepository->find(intval($id));
        $images = $imageRepository->findBy(["project" => $project]);
        $profileImage =  stream_get_contents($project->getProfileImage());


        $readyImages = [];

        foreach ($images as $image){
            $projectImage = stream_get_contents($image->getPath());
            array_push($readyImages, $projectImage);
        }


        return $this->render('user/projects/project.html.twig', [
            'controller_name' => 'UserController',
            'project' => $project,
            'readyImages' => $readyImages,
            'profileImage' => $profileImage,
        ]);


    }
}
