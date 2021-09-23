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
            var_dump($projectProfileImage[0]);
        }


        $em->flush();
        $this->addNewImagesAction($images, $em, $project);
//        $this->removeImages($removeImages, $em, $imageRepository);

        var_dump(1);
        exit();

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


    private function removeImagesAction($removeImages,  $em, ImageRepository  $imageRepository)
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
    public function removeImageFromProjectAction( $id, Request $request, ImageRepository  $imageRepository): Response
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
        var_dump(1);
        exit();

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
