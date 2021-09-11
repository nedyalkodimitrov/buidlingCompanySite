<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Project;
use App\Form\ImageType;
use App\Form\ProjectType;
use App\Repository\ImageRepository;
use App\Repository\ProjectRepository;
use App\Repository\ProjectTypeRepository;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Filesystem\Filesystem;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
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
     * @Route("/admin/project/{id}", name="project")
     */
    public function project($id,ImageRepository $imageRepository, ProjectRepository $projectRepository, ProjectTypeRepository $projectTypeRepository, Request $request, FileService $fileService): Response
    {

        $project = $projectRepository->find(intval($id));

        $projectImages = $imageRepository->findBy(["project" => $id]);
        $readyImages = [];

        foreach ($projectImages as $image){
            $imageContent = stream_get_contents($image->getPath());
            array_push($readyImages, $imageContent);
        }



        return $this->render('admin/project.html.twig', [
            'project' => $project,
            'images' => $readyImages,

        ]);

    }
    /**
     * @Route("/admin/newImages", name="newImages")
     */
    public function newImages( Request $request, FileService $fileService, ProjectRepository $projectRepository): Response
    {
       $images = $request->request->get('images');


       $project = $projectRepository->find(9);

       //upload images new project images
       foreach ($images as $imageCode){
           $image = new Image();
           $image->setPath($imageCode);
           $image->setProject($project);
           $em = $this->getDoctrine()->getManager();
           $em->persist($image);
           $em->flush();
           var_dump(1);
           exit();

       }



    }


}
