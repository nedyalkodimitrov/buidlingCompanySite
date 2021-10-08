<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Project;
use App\Repository\ImageRepository;
use App\Repository\MessageRepository;
use App\Repository\ProjectRepository;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPostController extends AbstractController
{
    /**
     * @Route("/admin/projectChanges", name="projectChanges")
     */
    public function projectChangesAction( Request $request, ImageRepository $imageRepository, ProjectRepository $projectRepository): Response
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
            $project->setDefaultImage(false);
        }


        $em->flush();
        $this->addNewImagesAction($images, $em, $project);
        $this->removeImagesAction($removeImages, $em, $imageRepository);

        return $this->json(1);

    }


    private function addNewImagesAction($images,  $em, Project $project)
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


    private function removeImagesAction($images,  $em, ImageRepository  $imageRepository)
    {

        //remove images from project
        if (is_array($images)){
            foreach ($images as $imageId){
                var_dump(intval($imageId));
                $image = $imageRepository->find(intval($imageId));
                $em->remove($image);

            }
        }

        $em->flush();


    }

    /**
     * @Route("/admin/removeImageFromProject/{id}", name="removeImageFromProject")
     */
    public function removeImageFromProjectAction( $id, Request $request, ImageRepository  $imageRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        $image = $imageRepository->find(intval($id));

        $em->remove($image);
        $em->flush();
      return $this->json(1);

    }


    /**
     * @Route("/admin/removeProject/{id}", name="removeProject")
     */
    public function removeProjectAction( $id, Request $request, ProjectRepository $projectRepository, ImageRepository $imageRepository): Response
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
        return $this->json(1);

    }

    /**
     * @Route("/admin/getMessage", name="getMessage")
     */
    public function getMessageAction( Request $request,MessageRepository $messageRepository): Response
    {
        $messageId = $request->request->get('messageId');
        $message = $messageRepository->find(intval($messageId));

        return $this->json($message);

    }
    /**
     * @Route("/admin/deleteMessage", name="deleteMessage")
     */
    public function deleteMessageAction( Request $request,MessageRepository $messageRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        $messageId = $request->request->get('messageId');
        $message = $messageRepository->find(intval($messageId));

        $em->remove($message);
        $em->flush();

        return $this->json(true);

    }



}
