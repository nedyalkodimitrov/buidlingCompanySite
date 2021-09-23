<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ImageRepository;
use App\Repository\MessageRepository;
use App\Repository\ProjectRepository;
use App\Repository\ProjectTypeRepository;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminGetController extends AbstractController
{
    /**
     * @Route("/admin", name="adminHome")
     */
    public function index(ProjectRepository $projectRepository, ProjectTypeRepository $projectTypeRepository, Request $request, FileService $fileService): Response
    {
        $projects = $projectRepository->findAll();
        $projectTypes = $projectTypeRepository->findAll();


        $projectObj = new Project();
        // $form = $this->createFormBuilder($projectObj)
        //     ->add("image", FileType::class,array('data_class' => null, ))
        //     ->add("button", SubmitType::class)
        //     ->getForm();
        // $form->handleRequest($request);
        $form = $this->createForm(ProjectType::class, $projectObj);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            var_dump($task);

//            //move file and return unique path
            $imagePath = $fileService->MoveImage($form);
            $task->setProfileImage($imagePath);
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('admin');
        }




        return $this->render('admin/index.html.twig', [
            'projects' => $projects,
            'projectTypes' => $projectTypes,
            'controller_name' => 'AdminController',
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/project/{id}", name="adminProject")
     */
    public function projectView($id,ImageRepository $imageRepository, ProjectRepository $projectRepository, ProjectTypeRepository $projectTypeRepository, Request $request, FileService $fileService): Response
    {

        $project = $projectRepository->find(intval($id));

        $projectImages = $imageRepository->findBy(["project" => $id]);
        $readyImages = [];

        foreach ($projectImages as $image){
            $imageInfo = [];
            $imageContent = stream_get_contents($image->getPath());
            array_push($imageInfo, $image->getId());
            array_push($imageInfo, $imageContent);
            array_push($readyImages,  $imageInfo);
        }



        return $this->render('admin/project.html.twig', [
            'project' => $project,
            'images' => $readyImages,
            'profileImage' => stream_get_contents($project->getProfileImage())

        ]);

    }

    /**
     * @Route("/admin/messages", name="messages")
     */
    public function messagesView( MessageRepository $messageRepository): Response
    {
        $messages = $messageRepository->findAll();

        return $this->render('admin/messages.html.twig', [
            'messages'=> $messages
        ]);
    }


}
