<?php


namespace App\Service;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Filesystem\Filesystem;

class FileService
{

    private $params;
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function MoveImage(FormInterface $form)
    {
        $filesystem = new Filesystem();
        $imageDirectory = 'imageDirectory';

        /** @var UploadedFile $file */
        $file = $form->get('profileImage')->getData();


        $imageNewFileName = $this->generateUniqueFileName() . uniqid() . '.' . 'jpg';

        try {

            $file->move(
                $this->params->get($imageDirectory),
                $imageNewFileName
            );
            return $imageNewFileName;
        } catch (\Exception $e) {
            return $imageNewFileName;
        }
    }


    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

}