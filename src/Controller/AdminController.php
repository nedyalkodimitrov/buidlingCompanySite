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
     * @Route("/admin/project/{id}", name="adminProject")
     */
    public function project($id,ImageRepository $imageRepository, ProjectRepository $projectRepository, ProjectTypeRepository $projectTypeRepository, Request $request, FileService $fileService): Response
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
     * @Route("/admin/message", name="removeProject")
     */
    public function message( $id, Request $request, ProjectRepository $projectRepository, ImageRepository $imageRepository): Response
    {
        return 0;
    }
    /**
     * @Route("/admin/projectChanges", name="projectChanges")
     */
    public function projectChanges( Request $request, ImageRepository $imageRepository, ProjectRepository $projectRepository): Response
    {
        $image = new Image();
        $images = $request->request->get('images');
        $projectId = $request->request->get('projectId');
        $projectProfileImage = $request->request->get('profileImage');
        $projectInformation = $request->request->get('information');
        $projectChanges = $request->request->get('changes');
        $removeImages = $request->request->get('deleteImages');

        $em = $this->getDoctrine()->getManager();


        $project = $projectRepository->find(intval($projectId));

        $project->setInformation($projectInformation);
        $project->setChanges($projectChanges);

        if(is_array($projectProfileImage)){

            $project->setProfileImage($projectProfileImage[0]);
            var_dump($projectProfileImage[0]);
        }


        $em->flush();
        $this->addNewImages($images, $em, $project);
//        $this->removeImages($removeImages, $em, $imageRepository);

        var_dump(1);
        exit();

    }


    private function addNewImages($images,  $em, Project $project)
    {

       //upload images new project images
       if (is_array($images)){
           foreach ($images as $imageCode){
               $image = new Image();
               $image->setPath($imageCode);
               $image->setProject($project);
               $em->persist($image);

           }
       }

       $em->flush();


    }


    private function removeImages($removeImages,  $em, ImageRepository  $imageRepository)
    {

        //upload images new project images
        if (is_array($removeImages)){
            foreach ($removeImages as $imageId){
                $image = $imageRepository->findBy(intval($imageId));
                $em->remove($image);

            }
        }

        $em->flush();
        var_dump(1);
        exit();

    }

    /**
     * @Route("/admin/removeImageFromProject/{id}", name="removeImageFromProject")
     */
    public function removeImageFromProject( $id, Request $request, ImageRepository  $imageRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        $image = $imageRepository->find(intval($id));

        $em->remove($image);
        $em->flush();
        var_dump(1);
        exit();

    }


    /**
     * @Route("/admin/removeProject/{id}", name="removeProject")
     */
    public function removeProject( $id, Request $request, ProjectRepository $projectRepository, ImageRepository $imageRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        $project = $projectRepository->find(intval($id));
        $images = $imageRepository->findBy(['project' => intval($id)]);

        if (is_array($images)){
            foreach ($images as $image){
                $em->remove($image);
            }
        }

        $em->remove($project);
        $em->flush();
        var_dump(1);
        exit();

    }


}
