<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
   
    /**
     * @ORM\ManyToOne(targetEntity="Project" )
     * @ORM\JoinColumn(name="project", referencedColumnName="id")
     */
    public $project;



    /**
         * @ORM\Column(type="blob")
     */
    private $path;




    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of project
     */ 
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set the value of project
     *
     * @return  self
     */ 
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get the value of path
     */ 
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return  self
     */ 
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstImage()
    {
        return $this->firstImage;
    }



}
